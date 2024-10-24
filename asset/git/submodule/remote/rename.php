<?php
/** op-skeleton-2020:/asset/git/remote/rename.php
 *
 *  Rename remote name to all submodules.
 *
 * <pre>
 * config : Specify the .gitmodules file to reference.
 * from   : Specify which remote name to change.
 * to     : Specify the remote name to change.
 * test   : Specify 1 explicitly to execute.
 * ```sh
 * php git.php asset/git/remote/rename.php config=.gitmodules from=origin to=upstream display=1 debug=0 test=1
 * ```
 * </pre>
 *
 * @created    2023-02-13
 * @version    1.0
 * @package    op-skeleton-2020
 * @author     Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright  Tomoaki Nagahara All right reserved.
 */

/** Declare strict
 *
 */
declare(strict_types=1);

/** namespace
 *
 */
namespace OP;

//	...
$config  = OP::Request('config')  ?? '.gitmodules';
$from    = OP::Request('from')    ?? null;
$to      = OP::Request('to')      ?? null;
$display = OP::Request('display') ?? 1;
$test    = OP::Request('test')    ?? 1;

//	...
foreach( ['config','from','to'] as $key ){
	if( empty(${$key}) ){
		D("This value is not set. ($key)");
		return;
	}
}

//	...
if( $test === '' ){
	$test = '1';
}
//	...
if( $test ){
	$display = $test;
	D('This is test mode. (test=1)');
}

/* @var $git UNIT\Git */
$git = OP::Unit('Git');

//	...
$configs = $git->SubmoduleConfig($config);

//	...
foreach( $configs as $config ){
	//	...
	$meta = 'git:/'.$config['path'];
	$path = OP::MetaPath($meta);
	if(!chdir($path) ){
		throw new \Exception("chdir was failed. ($path)");
	}
	if( $display ){ D($meta); }

	//	...
	if(!$git->Remote()->isExists($from) ){
		D("This remote name is not exists. ($from)");
		continue;
	}

	//	...
	if( $git->Remote()->isExists($to) ){
		D("This remote name is already exists. ($to)");
		continue;
	}

	//	...
	if( $test ){
		D("git remote rename {$from} {$to}");
	}else{
		$git->Remote()->Rename($from, $to);
	}
}
