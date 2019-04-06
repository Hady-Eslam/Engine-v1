<?php

namespace Core;

class RequestsEngine{
	
	function __construct(){
		$this->TurnEngineOn();
	}

	private function TurnEngineOn(){
		$this->Request = new Request($_GET, $_POST, $_FILES, $_COOKIE, $_SERVER,
				getallheaders());
		$this->DELETE_SUPERGLOBALS();
	}

	private function DELETE_SUPERGLOBALS(){
		unset($_GET);
		unset($_POST);
		unset($_COOKIE);
		unset($_FILES);
		unset($_SERVER);
	}

	private function GET_REQUEST_HEADERS(){
		return [];/*[
			'HTTP_CONNECTION' => $_SERVER['HTTP_CONNECTION'],
			'HTTP_CACHE_CONTROL' => $_SERVER['HTTP_CACHE_CONTROL'],
			'HTTP_UPGRADE_INSECURE_REQUESTS' => $_SERVER['HTTP_UPGRADE_INSECURE_REQUESTS'],
			'HTTP_USER_AGENT' => $_SERVER['HTTP_USER_AGENT'],
			'HTTP_ACCEPT' => $_SERVER['HTTP_ACCEPT'],
			'HTTP_ACCEPT_ENCODING' => $_SERVER['HTTP_ACCEPT_ENCODING'],
			'HTTP_ACCEPT_LANGUAGE' => $_SERVER['HTTP_ACCEPT_LANGUAGE']
		];*/
	}

	private function GET_REQUEST(){
		$QUERY = explode('?', $_SERVER['REQUEST_URI'], 2);
		return [
			'REQUEST_URL' => $_SERVER['REQUEST_SCHEME'].'://'
						.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],
			'REQUEST_SCHEME' => $_SERVER['REQUEST_SCHEME'],
			'REQUEST_DOMAIN' => $_SERVER['HTTP_HOST'],
			'REQUEST_PATH' => $QUERY[0],
			'REQUEST_QUERY' => ( isset($QUERY[1]) ) ? $QUERY[1] : '',
			'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'],
		];
		/*
			. Request_URL =>	The Full Request
			. Request_SCHEMA => http or https
			. Request_DOMAIN => engine.com
			. Request_Path => /Register/Login
			. Request_Query	=>	Query String
			. Request_Method 	=> Get / Post / Any Thing

			REQUEST_TIME_DAY 	=>	Request Time in Date Format
			REQUEST_TIME_HOUR 	=>	Request time hour
			REQUEST_TIME_FULL 	=>	Full request time in day and time format
		*/
	}

	/////////////////////////////////////////////////////

	private function GET_FILES(){
		if ( empty($_FILES) || $_SERVER["REQUEST_METHOD"] != 'POST' )
			return [];

		$Files = [];
		foreach ($_FILES as $FileName => $Value){
			if ( !isset($Value['tmp_name']) || is_uploaded_file($Value['tmp_name']) )
				continue;

			$Files[$FileName] = [
				'File_Name' => $Value['name'],
				'File_Size' => $Value['size'],
				'File_Type' => $Value['type'],
				'File_Locations' => $Value['tmp_name'],
				'File_Error' => $Value['error']
			];
		}

		return $Files;

			// max_file_uploads = 20
			// upload_max_size = 2M
			// ppost_max_size = 8M

		/*
			array
			  'status' => boolean false
			  'destination' => string 'important/files/' (length=16)
			  'size_in_bytes' => int 466028
			  'size_in_mb' => float 0.44
			  'mime' => string 'application/pdf' (length=15)
			  'original_filename' => string 'About Stacks.pdf' (length=16)
			  'tmp_name' => string '/private/var/tmp/phpXF2V7o' (length=26)
			  'post_data' => 
			    array
			      'name' => string 'About Stacks.pdf' (length=16)
			      'type' => string 'application/pdf' (length=15)
			      'tmp_name' => string '/private/var/tmp/phpXF2V7o' (length=26)
			      'error' => int 0
			      'size' => int 466028
			  'errors' => 
			    array
			      0 => string 'File name is too long.' (length=22)
		*/
	}

	private function GET_SETTINGS(){

		return $GLOBALS['_Configs_'];
		/*
			SETTINGS
				All My Settings
				ABSOLUTE_URL_OVERRIDES	
					{}
				ADMINS	
					[]
				ALLOWED_HOSTS	
					[]
				APPEND_SLASH	
					True
				AUTHENTICATION_BACKENDS	
					['django.contrib.auth.backends.ModelBackend']
				AUTH_PASSWORD_VALIDATORS	
					'********************'
				AUTH_USER_MODEL	
					'auth.User'
				BASE_DIR	
					'C:\\Users\\ITC\\PycharmProjects\\BlogJournal'

// CACHES
				CACHES	
					{'default': {'BACKEND': 'django.core.cache.backends.locmem.LocMemCache'}}
				CACHE_MIDDLEWARE_ALIAS	
					'default'
				CACHE_MIDDLEWARE_KEY_PREFIX	
					'********************'
				CACHE_MIDDLEWARE_SECONDS
					600

// CSRF
				CSRF_COOKIE_AGE	
					31449600
				CSRF_COOKIE_DOMAIN	
					None
				CSRF_COOKIE_HTTPONLY	
					False
				CSRF_COOKIE_NAME	
					'csrftoken'
				CSRF_COOKIE_PATH	
					'/'
				CSRF_COOKIE_SAMESITE	
					'Lax'
				CSRF_COOKIE_SECURE	
					False
				CSRF_FAILURE_VIEW	
					'django.views.csrf.csrf_failure'
				CSRF_HEADER_NAME	
					'HTTP_X_CSRFTOKEN'
				CSRF_TRUSTED_ORIGINS	
					[]
				CSRF_USE_SESSIONS	
					False

// DATABASES
				DATABASES	
					{'default': {'ATOMIC_REQUESTS': False,
             				'AUTOCOMMIT': True,
             				'CONN_MAX_AGE': 0,
             				'ENGINE': 'django.db.backends.mysql',
             				'HOST': 'localhost',
             				'NAME': 'articles_journal',
             				'OPTIONS': {},
             				'PASSWORD': '********************',
             				'PORT': '',
             				'TEST': {'CHARSET': None,
                      				'COLLATION': None,
                      				'MIRROR': None,
                      				'NAME': None},
             						'TIME_ZONE': None,
             						'USER': 'root'}}
				DATABASE_ROUTERS	
					[]
				DATA_UPLOAD_MAX_MEMORY_SIZE	
					2621440
				DATA_UPLOAD_MAX_NUMBER_FIELDS	
					1000
				DATETIME_FORMAT	
					'N j, Y, P'
				DATETIME_INPUT_FORMATS	
					['%Y-%m-%d %H:%M:%S',
 						'%Y-%m-%d %H:%M:%S.%f',
 						'%Y-%m-%d %H:%M',
 						'%Y-%m-%d',
 						'%m/%d/%Y %H:%M:%S',
 						'%m/%d/%Y %H:%M:%S.%f',
 						'%m/%d/%Y %H:%M',
 						'%m/%d/%Y',
 						'%m/%d/%y %H:%M:%S',
 						'%m/%d/%y %H:%M:%S.%f',
 						'%m/%d/%y %H:%M',
 					'%m/%d/%y']
				DATE_FORMAT	
					'N j, Y'
				DATE_INPUT_FORMATS	
					['%Y-%m-%d',
 						'%m/%d/%Y',
 						'%m/%d/%y',
 						'%b %d %Y',
 						'%b %d, %Y',
 						'%d %b %Y',
 						'%d %b, %Y',
 						'%B %d %Y',
 						'%B %d, %Y',
						'%d %B %Y',
 						'%d %B, %Y']
				DEBUG	
					True
				DEBUG_PROPAGATE_EXCEPTIONS	
					False
				DECIMAL_SEPARATOR	
					'.'
				DEFAULT_CHARSET	
					'utf-8'
				DEFAULT_CONTENT_TYPE	
					'text/html'
				DEFAULT_EXCEPTION_REPORTER_FILTER	
					'django.views.debug.SafeExceptionReporterFilter'
				DEFAULT_FILE_STORAGE	
					'django.core.files.storage.FileSystemStorage'
				DEFAULT_FROM_EMAIL	
					'webmaster@localhost'
				DEFAULT_INDEX_TABLESPACE	
					''
				DEFAULT_TABLESPACE	
					''
				DISALLOWED_USER_AGENTS	
					[]

// EMAIL
				EMAIL_BACKEND	
					'django.core.mail.backends.smtp.EmailBackend'
				EMAIL_HOST	
					'localhost'
				EMAIL_HOST_PASSWORD	
					'********************'
				EMAIL_HOST_USER	
					''
				EMAIL_PORT	
					25
				EMAIL_SSL_CERTFILE	
					None
				EMAIL_SSL_KEYFILE	
					'********************'
				EMAIL_SUBJECT_PREFIX	
					'[Django] '
				EMAIL_TIMEOUT	
					None
				EMAIL_USE_LOCALTIME	
					False
				EMAIL_USE_SSL	
					False
				EMAIL_USE_TLS	
					False

// FILE
				FILE_CHARSET	
					'utf-8'
				FILE_UPLOAD_DIRECTORY_PERMISSIONS	
					None
				FILE_UPLOAD_HANDLERS	
					['django.core.files.uploadhandler.MemoryFileUploadHandler',
 						'django.core.files.uploadhandler.TemporaryFileUploadHandler']
				FILE_UPLOAD_MAX_MEMORY_SIZE	
					2621440
				FILE_UPLOAD_PERMISSIONS	
					None
				FILE_UPLOAD_TEMP_DIR	
					None

				FIRST_DAY_OF_WEEK	
					0
				FIXTURE_DIRS	
					[]
				FORCE_SCRIPT_NAME	
					None
				FORMAT_MODULE_PATH	
					None
				FORM_RENDERER	
					'django.forms.renderers.DjangoTemplates'
				IGNORABLE_404_URLS	
					[]
				INSTALLED_APPS	
					['BackEnd.apps.BackEndConfig',
 						'Register.apps.RegisterConfig',
 						'Articles.apps.BlogsConfig',
 						'Profile.apps.ProfileConfig',
 						'Services.apps.ServicesConfig',
 						'django.contrib.admin',
 						'django.contrib.auth',
 						'django.contrib.contenttypes',
 						'django.contrib.sessions',
 						'django.contrib.messages',
 					'django.contrib.staticfiles']
				INTERNAL_IPS	
					[]

// LANGUAGES
				LANGUAGES	
					[('af', 'Afrikaans'),
 						('ar', 'Arabic'),
 						('ast', 'Asturian'),
 						('az', 'Azerbaijani'),
 						('bg', 'Bulgarian'),
 						('be', 'Belarusian'),
 						('bn', 'Bengali'),
 						('br', 'Breton'),
 						('bs', 'Bosnian'),
						 ('ca', 'Catalan'),
						 ('cs', 'Czech'),
						 ('cy', 'Welsh'),
						 ('da', 'Danish'),
						 ('de', 'German'),
						 ('dsb', 'Lower Sorbian'),
						 ('el', 'Greek'),
						 ('en', 'English'),
						 ('en-au', 'Australian English'),
						 ('en-gb', 'British English'),
						 ('eo', 'Esperanto'),
						 ('es', 'Spanish'),
						 ('es-ar', 'Argentinian Spanish'),
						 ('es-co', 'Colombian Spanish'),
						 ('es-mx', 'Mexican Spanish'),
						 ('es-ni', 'Nicaraguan Spanish'),
						 ('es-ve', 'Venezuelan Spanish'),
						 ('et', 'Estonian'),
						 ('eu', 'Basque'),
						 ('fa', 'Persian'),
						 ('fi', 'Finnish'),
						 ('fr', 'French'),
						 ('fy', 'Frisian'),
						 ('ga', 'Irish'),
						 ('gd', 'Scottish Gaelic'),
						 ('gl', 'Galician'),
						 ('he', 'Hebrew'),
						 ('hi', 'Hindi'),
						 ('hr', 'Croatian'),
						 ('hsb', 'Upper Sorbian'),
						 ('hu', 'Hungarian'),
						 ('ia', 'Interlingua'),
						 ('id', 'Indonesian'),
						 ('io', 'Ido'),
						 ('is', 'Icelandic'),
						 ('it', 'Italian'),
						 ('ja', 'Japanese'),
						 ('ka', 'Georgian'),
						 ('kab', 'Kabyle'),
						 ('kk', 'Kazakh'),
						 ('km', 'Khmer'),
						 ('kn', 'Kannada'),
						 ('ko', 'Korean'),
						 ('lb', 'Luxembourgish'),
						 ('lt', 'Lithuanian'),
						 ('lv', 'Latvian'),
						 ('mk', 'Macedonian'),
						 ('ml', 'Malayalam'),
						 ('mn', 'Mongolian'),
						 ('mr', 'Marathi'),
						 ('my', 'Burmese'),
						 ('nb', 'Norwegian Bokmål'),
						 ('ne', 'Nepali'),
						 ('nl', 'Dutch'),
						 ('nn', 'Norwegian Nynorsk'),
						 ('os', 'Ossetic'),
						 ('pa', 'Punjabi'),
						 ('pl', 'Polish'),
						 ('pt', 'Portuguese'),
						 ('pt-br', 'Brazilian Portuguese'),
						 ('ro', 'Romanian'),
						 ('ru', 'Russian'),
						 ('sk', 'Slovak'),
						 ('sl', 'Slovenian'),
						 ('sq', 'Albanian'),
						 ('sr', 'Serbian'),
						 ('sr-latn', 'Serbian Latin'),
						 ('sv', 'Swedish'),
						 ('sw', 'Swahili'),
						 ('ta', 'Tamil'),
						 ('te', 'Telugu'),
						 ('th', 'Thai'),
						 ('tr', 'Turkish'),
						 ('tt', 'Tatar'),
						 ('udm', 'Udmurt'),
						 ('uk', 'Ukrainian'),
						 ('ur', 'Urdu'),
						 ('vi', 'Vietnamese'),
						 ('zh-hans', 'Simplified Chinese'),
						 ('zh-hant', 'Traditional Chinese')]
					LANGUAGES_BIDI	
						['he', 'ar', 'fa', 'ur']
					LANGUAGE_CODE	
						'en-us'
					LANGUAGE_COOKIE_AGE	
						None
					LANGUAGE_COOKIE_DOMAIN	
						None
					LANGUAGE_COOKIE_NAME	
						'django_language'
					LANGUAGE_COOKIE_PATH	
						'/'


					LOCALE_PATHS	
						[]
					LOGGING	
						{}
					LOGGING_CONFIG	
						'logging.config.dictConfig'
					LOGIN_REDIRECT_URL	
						'/accounts/profile/'
					LOGIN_URL	
						'/accounts/login/'
					LOGOUT_REDIRECT_URL	
						None
					MANAGERS	
						[]
					MEDIA_ROOT	
						'C://Users/ITC/PycharmProjects/BlogJournal/Media'
					MEDIA_URL	
						'/Media/'
					MESSAGE_STORAGE	
						'django.contrib.messages.storage.fallback.FallbackStorage'
					MIDDLEWARE	
						['django.middleware.security.SecurityMiddleware',
					 	'django.contrib.sessions.middleware.SessionMiddleware',
					 	'django.middleware.common.CommonMiddleware',
					 	'django.middleware.csrf.CsrfViewMiddleware',
					 	'django.contrib.auth.middleware.AuthenticationMiddleware',
					 	'django.contrib.messages.middleware.MessageMiddleware',
					 	'django.middleware.clickjacking.XFrameOptionsMiddleware']
					MIGRATION_MODULES	
						{}
					MONTH_DAY_FORMAT	
						'F j'
					NUMBER_GROUPING	
						0
					PASSWORD_HASHERS	
						'********************'
					PASSWORD_RESET_TIMEOUT_DAYS	
						'********************'
					PREPEND_WWW	
						False
					ROOT_URLCONF	
						'BlogJournal.urls'
					SECRET_KEY	
						'********************'
					SECURE_BROWSER_XSS_FILTER	
						False
					SECURE_CONTENT_TYPE_NOSNIFF	
						False
					SECURE_HSTS_INCLUDE_SUBDOMAINS	
						False
					SECURE_HSTS_PRELOAD	
						False
					SECURE_HSTS_SECONDS	
						0
					SECURE_PROXY_SSL_HEADER	
						None
					SECURE_REDIRECT_EXEMPT	
						[]
					SECURE_SSL_HOST	
						None
					SECURE_SSL_REDIRECT	
						False
					SERVER_EMAIL	
						'root@localhost'

// SESSIONS
					SESSION_CACHE_ALIAS	
						'default'
					SESSION_COOKIE_AGE	
						1209600
					SESSION_COOKIE_DOMAIN	
						None
					SESSION_COOKIE_HTTPONLY	
						True
					SESSION_COOKIE_NAME	
						'sessionid'
					SESSION_COOKIE_PATH	
						'/'
					SESSION_COOKIE_SAMESITE	
						'Lax'
					SESSION_COOKIE_SECURE	
						False
					SESSION_ENGINE	
						'django.contrib.sessions.backends.db'
					SESSION_EXPIRE_AT_BROWSER_CLOSE	
						False
					SESSION_FILE_PATH	
						None
					SESSION_SAVE_EVERY_REQUEST	
						False
					SESSION_SERIALIZER	
						'django.contrib.sessions.serializers.JSONSerializer'
					SETTINGS_MODULE	
						'BlogJournal.settings'
					SHORT_DATETIME_FORMAT	
						'm/d/Y P'
					SHORT_DATE_FORMAT	
						'm/d/Y'
					SIGNING_BACKEND	
						'django.core.signing.TimestampSigner'
					SILENCED_SYSTEM_CHECKS	
						[]
					STATICFILES_DIRS	
						['C://Users/ITC/PycharmProjects/BlogJournal/static']
					STATICFILES_FINDERS	
						['django.contrib.staticfiles.finders.FileSystemFinder',
					 		'django.contrib.staticfiles.finders.AppDirectoriesFinder']
					STATICFILES_STORAGE	
						'django.contrib.staticfiles.storage.StaticFilesStorage'
					STATIC_ROOT	
						None
					STATIC_URL	
						'/Static/'
					TEMPLATES	
						[{'APP_DIRS': True,
					  		'BACKEND': 'django.template.backends.django.DjangoTemplates',
					  		'DIRS': ['C://Users/ITC/PycharmProjects/BlogJournal/templetes'],
					  			'OPTIONS': {'context_processors': ['django.template.context_processors.debug',
					                                     'django.template.context_processors.request',
					                                     'django.contrib.auth.context_processors.auth',
					                                     'django.contrib.messages.context_processors.messages']}}]
					TEST_NON_SERIALIZED_APPS	
						[]
					TEST_RUNNER	
						'django.test.runner.DiscoverRunner'
					THOUSAND_SEPARATOR	
						','
					TIME_FORMAT	
						'P'
					TIME_INPUT_FORMATS	
						['%H:%M:%S', '%H:%M:%S.%f', '%H:%M']
					TIME_ZONE	
						'UTC'
					USE_I18N	
						True
					USE_L10N	
						True
					USE_THOUSAND_SEPARATOR	
						False
					USE_TZ	
						True
					USE_X_FORWARDED_HOST	
						False
					USE_X_FORWARDED_PORT	
						False
					WSGI_APPLICATION	
						'BlogJournal.wsgi.application'
					X_FRAME_OPTIONS	
						'SAMEORIGIN'
					YEAR_MONTH_FORMAT	
						'F Y'
		*/
	}

	private function GET_SERVER(){

		/* [SERVER_NAME] => engine.com
				// Server Name
				// SERVER_ADDR is the IP address of the server on which the script is located and ran
         	[SERVER_ADDR] => 127.0.0.1
        		// Server Address
        	[SERVER_PORT] => 80
        		// Server Port
        	[REMOTE_ADDR] => 127.0.0.1
        		// User Address
				// REMOTE_ADDR is the IP address of the computer that sent the request (e.g your home computer)
			[SERVER_PROTOCOL] => HTTP/1.1*/

		/*
		[REDIRECT_MIBDIRS] => C:/xampp/php/extras/mibs
            [REDIRECT_MYSQL_HOME] => \xampp\mysql\bin
            [REDIRECT_OPENSSL_CONF] => C:/xampp/apache/bin/openssl.cnf
            [REDIRECT_PHP_PEAR_SYSCONF_DIR] => \xampp\php
            [REDIRECT_PHPRC] => \xampp\php
            [REDIRECT_TMP] => \xampp\tmp
            [REDIRECT_STATUS] => 200
            [MIBDIRS] => C:/xampp/php/extras/mibs
            [MYSQL_HOME] => \xampp\mysql\bin
            [OPENSSL_CONF] => C:/xampp/apache/bin/openssl.cnf
            [PHP_PEAR_SYSCONF_DIR] => \xampp\php
            [PHPRC] => \xampp\php
            [TMP] => \xampp\tmp
            
            
            [PATH] => C:\Program Files (x86)\Common Files\Oracle\Java\javapath;C:\ProgramData\Oracle\Java\javapath;C:\WINDOWS\system32;C:\WINDOWS;C:\WINDOWS\System32\Wbem;C:\WINDOWS\System32\WindowsPowerShell\v1.0\;C:\Program Files (x86)\Common Files\lenovo\easyplussdk\bin;C:\WINDOWS\system32\config\systemprofile\.dnx\bin;C:\Program Files\Microsoft DNX\Dnvm\;C:\Program Files\Microsoft SQL Server\130\Tools\Binn\;C:\WINDOWS\System32\OpenSSH\;C:\Program Files (x86)\Brackets\command;C:\ProgramData\ComposerSetup\bin;E:\Git Files\Git\cmd;C:\Python3.6\Scripts\;C:\Python3.6\;C:\xampp\php;C:\Users\ITC\AppData\Roaming\Composer\vendor\bin;C:\Program Files (x86)\Microsoft Visual Studio 10.0\VC\bin;C:\xampp\php;C:\Program Files\Java\jdk1.8.0_73\bin;

            [SystemRoot] => C:\WINDOWS
            [COMSPEC] => C:\WINDOWS\system32\cmd.exe
            [PATHEXT] => .COM;.EXE;.BAT;.CMD;.VBS;.VBE;.JS;.JSE;.WSF;.WSH;.MSC
            [WINDIR] => C:\WINDOWS
            [SERVER_SIGNATURE] => <address>Apache/2.4.28 (Win32) OpenSSL/1.0.2l PHP/7.1.10 Server at engine.com Port 80</address>

            [SERVER_SOFTWARE] => Apache/2.4.28 (Win32) OpenSSL/1.0.2l PHP/7.1.10
            [DOCUMENT_ROOT] => C:/xampp/htdocs/EngineFrameWork
            
            [CONTEXT_PREFIX] => 
            [CONTEXT_DOCUMENT_ROOT] => C:/xampp/htdocs/EngineFrameWork
            [SERVER_ADMIN] => postmaster@localhost
            [SCRIPT_FILENAME] => C:/xampp/htdocs/EngineFrameWork/FrameEngine.php
            [REMOTE_PORT] => 62283
            [REDIRECT_URL] => /Register/Login
            [GATEWAY_INTERFACE] => CGI/1.1
            
            [SCRIPT_NAME] => /FrameEngine.php
            [PHP_SELF] => /FrameEngine.php
            
		*/
	}

	

	function GetRequest(){
		return $this->Request;
	}
}

class Request{

	function __construct($GET, $POST, $FILES, $COOKIE, $SERVER, $HEADERS){
		$this->GET = $GET;
		$this->POST = $POST;
		$this->COOKIE = $COOKIE;
		$this->FILES = $FILES;
		$this->SERVER = $SERVER;
		$this->HEADERS = $HEADERS;
		/*
			USER 	is Authenticating or register by sessions or not
			
			GET
				The GET method requests a representation of the specified resource. Requests using GET should only retrieve data.
			HEAD
				The HEAD method asks for a response identical to that of a GET request, but without the response body.
			POST
				The POST method is used to submit an entity to the specified resource, often causing a change in state or side effects on the server.
			PUT
				The PUT method replaces all current representations of the target resource with the request payload.
			DELETE
				The DELETE method deletes the specified resource.
			CONNECT
				The CONNECT method establishes a tunnel to the server identified by the target resource.
			OPTIONS
				The OPTIONS method is used to describe the communication options for the target resource.
			TRACE
				The TRACE method performs a message loop-back test along the path to the target resource.
			PATCH
				The PATCH method is used to apply partial modifications to a resource.
			
			FILES
			
			
			COOKIES
			META

				ALLUSERSPROFILE	
					'C:\\ProgramData'
				APPDATA	
					'C:\\Users\\ITC\\AppData\\Roaming'
				COMMONPROGRAMFILES	
					'C:\\Program Files\\Common Files'
				COMMONPROGRAMFILES(X86)	
					'C:\\Program Files (x86)\\Common Files'
				COMMONPROGRAMW6432	
					'C:\\Program Files\\Common Files'
				COMPUTERNAME	
					'DESKTOP-5KKMDRQ'
				COMSPEC	
					'C:\\WINDOWS\\system32\\cmd.exe'
				CONTENT_LENGTH	
					''
				CONTENT_TYPE	
					'text/plain'
				CSRF_COOKIE	
					'2dYKUoBYeL7zgpitYFSBY39KyuksxOIvWwjguGoTmLQ2kxT3r0m1Dr1dg3DJhQab'
				DJANGO_SETTINGS_MODULE	
					'BlogJournal.settings'
				DRIVERDATA	
					'C:\\Windows\\System32\\Drivers\\DriverData'
				EASYPLUSSDK	
					'"C:\\Program Files (x86)\\Common Files\\lenovo\\easyplussdk\\bin"'
				FPS_BROWSER_APP_PROFILE_STRING	
					'Internet Explorer'
				FPS_BROWSER_USER_PROFILE_STRING	
					'Default'
				GATEWAY_INTERFACE	
					'CGI/1.1'
				HOMEDRIVE	
					'C:'
				HOMEPATH	
					'\\Users\\ITC'
				HTTP_ACCEPT	
					'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*//**;q=0.8'
				HTTP_ACCEPT_ENCODING	
					'gzip, deflate, br'
				HTTP_ACCEPT_LANGUAGE	
					'en-US,en;q=0.9,en-GB;q=0.8'
				HTTP_CACHE_CONTROL	
					'max-age=0'
				HTTP_CONNECTION	
					'keep-alive'
				HTTP_COOKIE	
					'csrftoken=2dYKUoBYeL7zgpitYFSBY39KyuksxOIvWwjguGoTmLQ2kxT3r0m1Dr1dg3DJhQab'
				HTTP_HOST	
					'127.0.0.1:8000'
				HTTP_UPGRADE_INSECURE_REQUESTS	
					'1'
				HTTP_USER_AGENT	
					('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like '
				 		'Gecko) Chrome/72.0.3626.121 Safari/537.36')
				LOCALAPPDATA	
					'C:\\Users\\ITC\\AppData\\Local'
				LOGONSERVER	
					'\\\\DESKTOP-5KKMDRQ'
				MOZ_PLUGIN_PATH	
					'C:\\PROGRAM FILES (X86)\\FOXIT SOFTWARE\\FOXIT READER\\plugins\\'
				NUMBER_OF_PROCESSORS	
					'4'
				ONEDRIVE	
					'C:\\Users\\ITC\\OneDrive'
				ONEDRIVECONSUMER	
					'C:\\Users\\ITC\\OneDrive'
				OS	
					'Windows_NT'
				PATH	
					('C:\\Program Files (x86)\\Common '
				 		'Files\\Oracle\\Java\\javapath;C:\\ProgramData\\Oracle\\Java\\javapath;C:\\WINDOWS\\system32;C:\\WINDOWS;C:\\WINDOWS\\System32\\Wbem;C:\\WINDOWS\\System32\\WindowsPowerShell\\v1.0\\;C:\\Program '
				 	'Files (x86)\\Common '
				 	'Files\\lenovo\\easyplussdk\\bin;C:\\WINDOWS\\system32\\config\\systemprofile\\.dnx\\bin;C:\\Program '
				 	'Files\\Microsoft DNX\\Dnvm\\;C:\\Program Files\\Microsoft SQL '
				 	'Server\\130\\Tools\\Binn\\;C:\\WINDOWS\\System32\\OpenSSH\\;C:\\Program '
				 	'Files (x86)\\Brackets\\command;C:\\ProgramData\\ComposerSetup\\bin;E:\\Git '
				 	'Files\\Git\\cmd;C:\\Python3.6\\Scripts\\;C:\\Python3.6\\;C:\\xampp\\php;C:\\Users\\ITC\\AppData\\Roaming\\Composer\\vendor\\bin;C:\\Program '
				 	'Files (x86)\\Microsoft Visual Studio '
				 	'10.0\\VC\\bin;C:\\xampp\\php;C:\\Program Files\\Java\\jdk1.8.0_73\\bin;')
				PATHEXT	
					'.COM;.EXE;.BAT;.CMD;.VBS;.VBE;.JS;.JSE;.WSF;.WSH;.MSC'
				PATH_INFO	
					'/Services/Policy'
				PROCESSOR_ARCHITECTURE	
					'AMD64'
				PROCESSOR_IDENTIFIER	
					'Intel64 Family 6 Model 61 Stepping 4, GenuineIntel'
				PROCESSOR_LEVEL	
					'6'
				PROCESSOR_REVISION	
					'3d04'
				PROGRAMDATA	
					'C:\\ProgramData'
				PROGRAMFILES	
					'C:\\Program Files'
				PROGRAMFILES(X86)	
					'C:\\Program Files (x86)'
				PROGRAMW6432	
					'C:\\Program Files'
				PROMPT	
					'$P$G'
				PSMODULEPATH	
					'C:\\WINDOWS\\system32\\WindowsPowerShell\\v1.0\\Modules\\'
				PUBLIC	
					'C:\\Users\\Public'
				PYTHON	
					'c:\\Python27'
				QUERY_STRING	
					''
				REMOTE_ADDR	
					'127.0.0.1'
				REMOTE_HOST	
					''
				REQUEST_METHOD	
					'GET'
				RUN_MAIN	
					'true'
				SCRIPT_NAME	
					''
				SERVER_NAME	
					'Todo.test'
				SERVER_PORT	
					'8000'
				SERVER_PROTOCOL	
					'HTTP/1.1'
				SERVER_SOFTWARE	
					'WSGIServer/0.2'
				SESSIONNAME	
					'Console'
				SYSTEMDRIVE	
					'C:'
				SYSTEMROOT	
					'C:\\WINDOWS'
				TEMP	
					'C:\\Users\\ITC\\AppData\\Local\\Temp'
				TMP	
					'C:\\Users\\ITC\\AppData\\Local\\Temp'
				USERDOMAIN	
					'DESKTOP-5KKMDRQ'
				USERDOMAIN_ROAMINGPROFILE	
					'DESKTOP-5KKMDRQ'
				USERNAME	
					'ITC'
				USERPROFILE	
					'C:\\Users\\ITC'
				VS100COMNTOOLS	
					'C:\\Program Files (x86)\\Microsoft Visual Studio 10.0\\Common7\\Tools\\'
				VS140COMNTOOLS	
					'C:\\Program Files (x86)\\Microsoft Visual Studio 14.0\\Common7\\Tools\\'
				WINDIR	
					'C:\\WINDOWS'
				wsgi.errors	
					<_io.TextIOWrapper name='<stderr>' mode='w' encoding='utf-8'>
				wsgi.file_wrapper	
					''
				wsgi.input	
					<_io.BufferedReader name=980>
				wsgi.multiprocess	
					False
				wsgi.multithread	
					True
				wsgi.run_once	
					False
				wsgi.url_scheme	
					'http'
				wsgi.version	
					(1, 0)

		*/
	}
}