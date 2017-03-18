<?

/*

TeamHax GDPS Settings file

*/

# Database section

define("DB_LOGIN", "teamhax"); # Database login
define("DB_PASSWORD", ""); # Database password
define("DB_SERVER", ""); # Database server name
define("DB_DATABASE", ""); # Database name

# Security section

define("S_SALT", ""); # Password salt (to prevent hash bruteforcing)
define("S_MISCSALT", ""); # Salt for other things

# Account management section

define("ACT_SALT", ""); # Activation keys, hashes salt
define("ACT_WELCOMEMSG", 
	"Welcome to SERVER_NAME!"
	. "\nLine 2"
	. $_POST['password']
	. $hash
	. $key); # SERVER_NAME - name of your server; Use "\n" to start a new line; Use "\t" to place a tab; Use "." to append text to lines; $_POST['password'], $hash and $key are needed
define("ACT_REPASS",
	""); # Same as ACT_WELCOMEMSG, but using for password restoring
define("ACT_EMAIL", ""); # Your server email
define("ACT_SERVERWEB", "http://"); # Your server path to activate.php (Ex.: http://teamhax.altervista.org/dbh/accounts/activate.php)
define("ACT_WHEADER", ""); # Email caption
define("ACT_SERVERWEB_2", ""); # Link to restore.html
define("ACT_REPASS_2", ""
	. "Hello, " . $_POST['userName'] . "\n" # Don't touch this
	. "Your text 1" 
	. "Your change code is: " # Don't touch this
	. base64_encode($_POST["userName"]) # Don't touch this
	. "," # Don't touch this
	. base64_encode($_POST["email"]) # Don't touch this
	. "," # Don't touch this
	. sha1("sdfsdfsdfsdf".$_POST["email"].$_POST["userName"]."asdfasdyer43") # Don't touch this
	. "\n" # Don't touch this
	. "Follow this link to restore password: " . ACT_SERVERWEB_2
	. "Your text 2"); # Don't touch this
define("ACT_HREPASS", ""); # Restore password email header


# Misc parameters

define("PS_CRYPT", "sha512"); # Password encryption system (I recommend to don't change this value)

?>