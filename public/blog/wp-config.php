<?php
/**
 * WordPress基础配置文件。
 *
 * 这个文件被安装程序用于自动生成wp-config.php配置文件，
 * 您可以不使用网站，您需要手动复制这个文件，
 * 并重命名为“wp-config.php”，然后填入相关信息。
 *
 * 本文件包含以下配置选项：
 *
 * * MySQL设置
 * * 密钥
 * * 数据库表名前缀
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/zh-cn:%E7%BC%96%E8%BE%91_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL 设置 - 具体信息来自您正在使用的主机 ** //
/** WordPress数据库的名称 */
define('DB_NAME', 'wordpress');

/** MySQL数据库用户名 */
define('DB_USER', 'root');

/** MySQL数据库密码 */
define('DB_PASSWORD', '123456abc');

/** MySQL主机 */
define('DB_HOST', '127.0.0.1');

/** 创建数据表时默认的文字编码 */
define('DB_CHARSET', 'utf8mb4');

/** 数据库整理类型。如不确定请勿更改 */
define('DB_COLLATE', '');

/**#@+
 * 身份认证密钥与盐。
 *
 * 修改为任意独一无二的字串！
 * 或者直接访问{@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org密钥生成服务}
 * 任何修改都会导致所有cookies失效，所有用户将必须重新登录。
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '=cw1yM3.%WBv,7( r@;!Bvwta.%KfJ[Y`BM}F2psnnM$T)JbrY#.5ID$t|1jNj!g');
define('SECURE_AUTH_KEY',  'pWKnud<}aMQ;`VfCU(DmBPt-u1J183>%5LYU.}H){a)r.Ny^Ep(_%fHs8+&/#gVq');
define('LOGGED_IN_KEY',    '],sRoe*`ZgA6/#,M=a-hv!]E</i2!J<-6?@ll#!)GlXFb]n,E>P<Y{J9=vERC3,z');
define('NONCE_KEY',        'JiL%rDtySl=TJ&#+[[;J+CcFC&/X*_X<w/E<1Fgzu~q8(4fMt@wT*rcp8]M`w)#[');
define('AUTH_SALT',        'H.1f!(4qqa&/2jUel_GO,3Pg-^i642xIA_JBnn;f|f2WQn7]GRN2);%Z-<C 56ic');
define('SECURE_AUTH_SALT', '%[<v/[Oiz~%@}cy`@g3,^6t9{}a)+9kEC7?oU8:~CNrFT>X3,LIxOSP22h7kvu25');
define('LOGGED_IN_SALT',   '4p[A<Vf2[i1GMu@p_@w7IIkh.UR ]-?<3KBSRcar9GQ~3L(%e:owd@u4U*#UZ8k=');
define('NONCE_SALT',       'AHi<R$F{]$|B7ho,]=2z(IH8lfQT[3#]BIm90%7t$UPsV})SM@)VHL/xjrL UG@/');

/**#@-*/

/**
 * WordPress数据表前缀。
 *
 * 如果您有在同一数据库内安装多个WordPress的需求，请为每个WordPress设置
 * 不同的数据表前缀。前缀名只能为数字、字母加下划线。
 */
$table_prefix  = 'wp_';

/**
 * 开发者专用：WordPress调试模式。
 *
 * 将这个值改为true，WordPress将显示所有用于开发的提示。
 * 强烈建议插件开发者在开发环境中启用WP_DEBUG。
 *
 * 要获取其他能用于调试的信息，请访问Codex。
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* 好了！请不要再继续编辑。请保存本文件。使用愉快！ */

/** WordPress目录的绝对路径。 */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** 设置WordPress变量和包含文件。 */
require_once(ABSPATH . 'wp-settings.php');

