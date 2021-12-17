<?php
/*
 * phpcount.php Ver.1.1- An "anoymizing" hit counter.
 * Copyright (C) 2013  Taylor Hornby
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

/*
 * This PHP Class provides a hit counter that is able to track unique hits
 * without recording the visitor's IP address in the database. It does so by 
 * recording the hash of the IP address and page name.
 *
 * By hashing the IP address with page name as salt, you prevent yourself from
 * being able to track a user as they navigate your site. You also prevent 
 * yourself from being able to recover anyone's IP address without brute forcing
 * through all of the assigned IP address blocks in use by the internet.
 *
 * Contact: havoc AT defuse.ca
 * WWW:     https://defuse.ca/
 *
 * USAGE:
 *        In your script, use reqire_once() to import this script, then call the
 *        functions like PHPCount::AddHit(...); See each function for help.
 *
 * NOTE: You must set the database credentials in the InitDB method.
 */

class PHPCount
{
   /*
    * Defines how many seconds a hit should be rememberd for. This prevents the
    * database from perpetually increasing in size. Thirty days (the default)
    * works well. If someone visits a page and comes back in a month, it will be
    * counted as another unique hit.
    */
    const HIT_OLD_AFTER_SECONDS = 2592000; // default: 30 days.

    // Don't count hits from search robots and crawlers.
    const IGNORE_SEARCH_BOTS = true;

    // Don't count the hit if the browser sends the DNT: 1 header.
    const HONOR_DO_NOT_TRACK = false;

    private static $IP_IGNORE_LIST = array(
        '127.0.0.1',
    );

    private static $DB = false;

    private static $hitstbl = false;

    private static $dupstbl = false;

    public static function InitDB($servername, $username, $password, $hitstbl, $dupstbl, $counters_db)
    {
        if(self::$DB)
            return;

        try
        {
            // Set the database login credentials.
            self::$DB = new PDO(
                'mysql:host='.$servername.';dbname='.$counters_db,
                $username, // Username
                $password, // Password
                array(PDO::ATTR_PERSISTENT => true)
            );
            self::$hitstbl = $hitstbl;
            self::$dupstbl = $dupstbl;
        }
        catch(Exception $e)
        {
            die('Failed to connect to phpcount database');
        }
    }

    public static function setDBAdapter($db)
    {
        self::$DB = $db;
        return $db;
    }

    /*
     * Adds a hit to a page specified by a unique $pageID string.
     */
    public static function AddHit($pageID)
    {
        if(self::IGNORE_SEARCH_BOTS && self::IsSearchBot())
            return false;
        if(in_array($_SERVER['REMOTE_ADDR'], self::$IP_IGNORE_LIST))
            return false;
        if(
            self::HONOR_DO_NOT_TRACK &&
            isset($_SERVER['HTTP_DNT']) && $_SERVER['HTTP_DNT'] == "1"
        ) {
            return false;
        }

        //self::InitDB();

        self::Cleanup();
        if(self::UniqueHit($pageID))
        {
            self::CountHit($pageID, true);
            self::LogHit($pageID);
        }
        self::CountHit($pageID, false);

        return true;
    }
    
    /*
     * Returns (int) the amount of hits a page has
     * $pageID - the page identifier
     * $unique - true if you want unique hit count
     */
    public static function GetHits($pageID, $unique = false)
    {
        //self::InitDB();

        $q = self::$DB->prepare(
            'SELECT hitcount FROM '.self::$hitstbl.'
             WHERE pageid = :pageid AND isunique = :isunique'
        );
        $q->bindParam(':pageid', $pageID);
        $q->bindParam(':isunique', $unique);
        $q->execute();

        if(($res = $q->fetch()) !== FALSE)
        {
            return (int)$res['hitcount'];
        }
        else
        {
            //die("Missing hit count from database!");
            return 0;
        }
    }
    
    /*
     * Returns the total amount of hits to the entire website
     * When $unique is FALSE, it returns the sum of all non-unique hit counts
     * for every page. When $unique is TRUE, it returns the sum of all unique
     * hit counts for every page, so the value that's returned IS NOT the 
     * amount of site-wide unique hits, it is the sum of each page's unique
     * hit count.
     */
    public static function GetTotalHits($unique = false)
    {
        //self::InitDB();

        $q = self::$DB->prepare(
            'SELECT hitcount FROM '.self::$hitstbl.' WHERE isunique = :isunique'
        );
        $q->bindParam(':isunique', $unique);
        $q->execute();
        $rows = $q->fetchAll();

        $total = 0;
        foreach($rows as $row)
        {
            $total += (int)$row['hitcount'];
        }
        return $total;
    }
    
    /*====================== PRIVATE METHODS =============================*/
    
    private static function IsSearchBot()
    {
        // Of course, this is not perfect, but it at least catches the major
        // search engines that index most often.
        $keywords = array(
            'bot',
            'spider',
            'spyder',
            'crawlwer',
            'walker',
            'search',
            'yahoo',
            'holmes',
            'htdig',
            'archive',
            'tineye',
            'yacy',
            'yeti',
        );

        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);

        foreach($keywords as $keyword) 
        {
            if(strpos($agent, $keyword) !== false)
                return true;
        }

        return false;
    }

    private static function UniqueHit($pageID)
    {
        $ids_hash = self::IDHash($pageID);

        $q = self::$DB->prepare(
            'SELECT `time` FROM '.self::$dupstbl.' WHERE ids_hash = :ids_hash'
        );
        $q->bindParam(':ids_hash', $ids_hash);
        $q->execute();

        if(($res = $q->fetch()) !== false)
        {
            if($res['time'] > time() - self::HIT_OLD_AFTER_SECONDS)
                return false;
            else
                return true;
        }
        else
        {
            return true;
        }
    }
    
    private static function LogHit($pageID)
    {
        $ids_hash = self::IDHash($pageID);

        $q = self::$DB->prepare(
            'SELECT `time` FROM '.self::$dupstbl.' WHERE ids_hash = :ids_hash'
        );
        $q->bindParam(':ids_hash', $ids_hash);
        $q->execute();

        $curTime = time();

        if(($res = $q->fetch()) !== false)
        {
            $s = self::$DB->prepare(
                'UPDATE '.self::$dupstbl.' SET `time` = :time WHERE ids_hash = :ids_hash'
            );
            $s->bindParam(':time', $curTime);
            $s->bindParam(':ids_hash', $ids_hash);
            $s->execute();
        }
        else
        {
            $s = self::$DB->prepare(
                'INSERT INTO '.self::$dupstbl.' (ids_hash, `time`)
                 VALUES( :ids_hash, :time )'
            );
            $s->bindParam(':time', $curTime);
            $s->bindParam(':ids_hash', $ids_hash);
            $s->execute();
        }
    }
    
    private static function CountHit($pageID, $unique)
    {
        $q = self::$DB->prepare(
            'INSERT INTO '.self::$hitstbl.' (pageid, isunique, hitcount) VALUES (:pageid, :isunique, 1) ' .
            'ON DUPLICATE KEY UPDATE hitcount = hitcount + 1'
        );
        $q->bindParam(':pageid', $pageID);
        $unique = $unique ? '1' : '0';
        $q->bindParam(':isunique', $unique);
        $q->execute();
    }
    
    private static function IDHash($pageID)
    {
        $visitorID = $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'];
        return hash("SHA256", $pageID . $visitorID);
    }

    private static function Cleanup()
    {
        $last_interval = time() - self::HIT_OLD_AFTER_SECONDS;

        $q = self::$DB->prepare(
            'DELETE FROM '.self::$dupstbl.' WHERE `time` < :time'
        );
        $q->bindParam(':time', $last_interval);
        $q->execute();
    }
}