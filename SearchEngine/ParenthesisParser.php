<?php
/**
 * Created by Amar Gawade.
 * User: Gas10
 * Date: 1/30/17
 * Time: 4:51 PM
 * Version: 1.0.0
 */
class ParenthesisParser
{
    protected $stack = null;
    protected $current = null;
    protected $string = null;
    protected $position = null;
    protected $buffer_start = null;

    public function parseParenthesis($string)
    {
        if (!$string) {
            return array();
        }

        if ($string[0] == '(') {
            $string = substr($string, 1, -1);
        }

        $this->current = array();
        $this->stack = array();

        $this->string = $string;
        $this->length = strlen($this->string);
        // look at each character
        for ($this->position=0; $this->position < $this->length; $this->position++) {
            switch ($this->string[$this->position]) {
                case '(':
                    $this->push();
                    array_push($this->stack, $this->current);
                    $this->current = array();
                    break;

                case ')':
                    $this->push();
                    $t = $this->current;
                    $this->current = array_pop($this->stack);
                    $this->current[] = $t;
                    break;

                case ' ':
                     $this->push();
                     break;

                default:
                     if ($this->buffer_start === null) {
                        $this->buffer_start = $this->position;
                    }
            }
        }

        return $this->current;
    }

    protected function push()
    {
        if ($this->buffer_start !== null) {
            $buffer = substr($this->string, $this->buffer_start, $this->position - $this->buffer_start);
            $this->buffer_start = null;
            $this->current[] = $buffer;
        }
    }
}

?>