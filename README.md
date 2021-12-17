## Hippocampome Development Model

Source code for all aspects of the Hippocampome project is maintained on GitHub under the "hippocampome" account.  Individual repositories under this account are accessible using the URL scheme `http://github.com/REPOSITORY_NAME`.  These repositories are public-- anyone can read from them.

A repository is maintained on Github for each aspect of the project.  At present the only repository is 'php', which contains PHP portal code.  Eventually the database import code will be added.  A 'wrapper' repository named 'hippocampome' that contains the others as submodules may also be added at some point.

Individual developers that wish to work on an aspect of the project need to create a Github account.  Once the Github account is created, that account must be added as a collaborator to the central hippocampome account.  This will enable the holder of the new account to write ('push') to repositories under the hippocampome account.

### Production, Development, Review

The Github Hippocampome repository has one core branch: 'master'.  As individual developers complete experimental changes, the changes will typically be pushed up onto this master branch.  This branch does NOT contain production code; it's really a dev master branch.

The Hippocampome server will maintain three versions of the repo.  Production, review and development sites are implemented by pulling from the Github repo at particular times.  Development will frequently be pulling in new features from Github-- when they've been judged stable, review can pull.  When the review stage is passed, a tag (permanent reference to a snapshot) can be created to the particular commit on the review site, the tag can be pushed up to Github, and the tag can then be pulled down onto production.

There should be no need for most people making code changes to interact with any of these Hippocampome server repos.  They need only push their changes up to Github.

## Tutorial

### Getting Started with Git and Github

- Create a Github account [here](https://github.com)
- Follow the download link and instructions [here](https://help.github.com/articles/set-up-git).  If you're on Mac or Linux, you probably don't need to download as Git should already be installed.
- Git can be used from either the command line or various GUIs. Github provides free GUIs for all platforms.  If you use the command line on Windows, you should probably use the "git bash" utility that comes with git, instead of the Windows command prompt.

### Getting Started Working on Portal PHP (Command Line)

- Let David know your Github username so he can add you as a collaborator on the php project.  This will let you write ('push') to the Hippocampome repos.
- Navigate to the directory where you want to store the project (which is itself a directory)  
`cd path/to/where/I/want/my/repo`
- Clone (copy) the repository from Github to your machine  
`git clone https://github.com/hippocampome/php.git`

- This will create a project folder that contains the git repository and working tree.  The repo will come with one 'remote' and two branches:
    - the remote is a reference to the remote repo you just cloned, which is called 'origin' and points to the above URL
    - one remote-tracking branch called 'origin/master'
    - one local branch called 'master', currently checked out, that is set up to track origin/master.  This means that, when the 'master' branch is checked out, `git pull` and `git fetch` commands are executed relative to the origin/master branch.

Once you have made some changes that you are ready to commit to the dev site:

- Stage your changes to be committed to your local master branch  
`git add .`
- Commit the changes to your local master branch  
`git commit -m "COMMIT MESSAGE HERE"`
- Fetch down any updates that might have occurred while you were working
`git fetch`
- Rebase to apply your changes to the newest version that was just pulled down
`git rebase origin/master`
- An alternative to rebase is to use merge here
`git merge origin/master`
- Push the changes up to the github version of the dev branch  
`git push`

In order for `git push` to work here, you must be added as a collaborator on the Hippocampome Github account.  That's because you'll be actually writing to the account's php repo.

*NOTE: `git push` will fail if someone else has pushed to the remote since you branched off of it and you have not yet incorporated their changes.  This will prevent you from overwriting changes other people made.  In order to incorporate any changes made by others while you were working, you perform a `git fetch` followed by a `git rebase` or `git merge`.  The `fetch` retrieves their work, and the `rebase` or `merge` incorporates it into your own.  `rebase` and `merge` do similar things, but rebase does it in a way that keeps the history cleaner.  You should never use rebase for changes that you've already pushed-- use merge instead.  Just use rebase when you want to apply private changes you've been working on to the most recent version of the central repo. More on rebase/merge differences [here](http://git-scm.com/book/en/Git-Branching-Rebasing)*

## Git and Github

Git is a distributed version control system (DVCS).  The "distributed" part means that, for a given project, there is no central repository (repo)-- just one or more peer repos, which may be stored on any computer.  Github is merely one more place for repos to live that provides a nice interface that can be accessed from any computer on the Internet.

### Git Repositories

A git repo is a directory (typically named '.git') that contains a full history of a project.  The repo is updated by running 'commit' and 'merge' operations.

A project being managed with git has two parts: the repository and the working tree.  The repository typically is a top-level subdirectory of the project and is named '.git'.  It contains a full history of all the files associated with your project in a highly compressed form.  The working tree is a particular snapshot of the project in human-editable form.  It consists of the files as you usually see them on the filesystem.  The working tree may be changed when a new branch or commit is 'checked out'.

A repo may contain references to one or more remote repos that are other versions of the same project.  These references consist of an alias (frequently 'origin') and a URL.  This reference is used to push and pull updates between your repo and the the remote one.  By keeping one 'hub' version of a repo at a central source (i.e. GitHub) and having developers maintain their own local versions of that repo that contain references to the hub, collaboration is greatly facilitated.

 More on repositories [here](http://gitref.org/creating/).

### Git Branches

Git branches are different versions of a codebase contained within the same repository, "branching" off of a shared trunk (the code the branches hold in common).  Each branch has a working tree representation.  New branches may be created, deleted, or merged with other branches at any time.  When merging, git intelligently recognizes differences between the two branches and, in most cases, automatically resolves those differences (by interleaving the lines of the two versions of a given file).  In some cases it's not able to do this (because the same line has been changed in the two versions) and git alerts you that there are merge conflicts, which must be manually resolved.

Experimental, short-lived branches might be created when a developer decides to add a new feature.  These branches will be merged back into a main branch (often called 'master') when the changes are stable, and the experimental branch deleted.  A project might also contain several permanent or long-term branches.

Each branch corresponds to a particular version of a project.  When working on the project, one and only one branch is active at a given time.  This branch can be chosen with the `git checkout` command.  This command will actually change the representation of the project presented to the user on the filesystem (the working tree)-- i.e. if you are looking at the project folder in Windows Explorer or OS X Finder and you use `checkout` to switch branches, you may actually see the contents of the folder change.  Don't worry, the old contents still exist, and you can switch back to them with `checkout`.

More on branches [here](http://gitref.org/branching/).

### Git Command Line

Command line git is a command suite, which means that you run commands in the general form `git COMMAND`.  `git` is a prefix for everything you do.

To use Git from the command line, you'll typically (unless cloning or initializing a new repo) need to navigate to the root of your project (i.e. be in the directory that contains the '.git' directory).  Once there, you can run a variety of commands which are executed relative to that project.

Here are the minimum basic commands you will need for working with the Hippocampome.  General syntax is below the description of each command, followed by a bolded example of this command used in the context of the Hippocampome:

- Clone a repository:  
`git clone REPO_URL`  
**`git clone https://github.com/hippocampome/php.git`**
- Stage changes to be committed to your local version:  
`git add .`  
**`git add .`**
- Commit changes to your local version:  
`git commit -m "COMMIT_MESSAGE"`  
**`git commit -m "add new author search functionality"`**
- Push a branch of your local version to the remote version:  
`git push REMOTE_ALIAS LOCAL_BRANCH_NAME`  
**`git push origin master`**
- Fetch updates from a remote repo
`git fetch REMOTE_ALIAS`  
**`git fetch origin`**
- Merge another branch into your current branch
`git merge BRANCH_NAME`  
**`git merge origin/master`**
- Fetch updates and then automatically merge those from a matching remote branch into your local branch  
`git pull REMOTE_ALIAS`  
**`git pull origin`**

*NOTE: if you are on a branch that is 'tracking' a remote branch, then you can run `git push` and `git pull` without arguments.  The name of your current branch will be used as the source, and the remote branch being tracked is automatically set as the target.

### Git GUIs

TODO

### More on Git

The above provides the bare minimum of information.  If you want to know more, you should go through the below pages at [GitRef](http://gitref.org).  Particularly recommended is the 'Staging, Adding, Committing, Etc' section; this will help you understand the `git add .` and `git commit` commands.

- [Creating Repos](http://gitref.org/creating/)
- [Staging, Adding, Committing, Etc](http://gitref.org/basic/)
- [Branching/Merging/Etc](http://gitref.org/branching/)
- [Remote Repos](http://gitref.org/remotes/)
- [Inspecting and Comparing Repos](http://gitref.org/inspect/)

[Here](http://git-scm.com/book/en/Git-Branching-Remote-Branches) is a much more in-depth look at the mechanics of remotes and branching  

[Here](http://git-scm.com/book/en/Git-Branching-Rebasing) is a good reference for understanding the difference between rebase and merge


