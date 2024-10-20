
 ## op-skeleton-2020:/asset/git/submodule/init.sh
 #
 # @created    ????
 # @version    1.0
 # @package    op-skeleton-2020
 # @author     Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 # @copyright  Tomoaki Nagahara All right reserved.
 #

# branch name
BRANCH=${1:-2022}

# Init git submodule
# git submodule init
# git submodule update
git submodule update --init --recursive
# git submodule foreach git checkout $BRANCH
