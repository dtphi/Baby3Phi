<?php
define('B3P_INSTALLING', true);
/**
 * Prefix database.
 */
define('DB_PREFIX', 'db_');

/**
 * Prefix table.
 */
define('TBL_PREFIX', 'b3p_');

define('B3P_TOOL_MM_ID', 'mm-server');

define('B3P_TOOL_MM_COOKIE_VALIDATION_KEY', 'base64:A6X15ee7aZgZJ9Vy1rpOdWoD7/kXuG0+D/bVdkfSBwc=');

define('B3P_TOOL_MM_ACCESS_CONTROL_MAX_AGE', 86400);

/**
 * The class name upload file .
 */
define('B3P_TOOL_MM_FILE_MANAGER_UPLOAD_HELPER_CLASS', 'App\Helpers\UploadLocalFilesystem');

/**
 * The new image directory .
 */
define('B3P_TOOL_MM_FILE_MANAGER_PATH', '@webroot/Image/NewPicture');

/**
 * The tmp directory for thumb .
 */
define('B3P_TOOL_MM_FILE_MANAGER_THUMB_PATH', '@webroot/.tmb');

define('B3P_TOOL_MM_FILE_MANAGER_THUMB_DIR', '@web/.tmb');

/**
 * The default thumb size .
 */
define('B3P_TOOL_MM_FILE_MANAGER_THUMB_SIZE', 'thumb');

define('B3P_ADMIN_PREFIX', 'admin');

define('B3P_ADMIN_LOGIN_PATH', 'admin/login');

define('B3P_PRODUCTION_ENV', 'production');

define('B3P_STAGING_ENV', 'staging');

define('B3P_SLASH_DIR', DIRECTORY_SEPARATOR);

define('B3P_ADMIN_LIMIT', 2);

define('B3P_FRONT_LIMIT', 20);

define('B3P_APP_NAME', 'b3p-ba-phi-ba-bi');

define('NO_THUMB_IMG','/images/no-photo.jpg');

define('NO_FRONT_THUMB_IMG','/images/default_image.jpg');
