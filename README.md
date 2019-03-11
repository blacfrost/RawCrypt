# RawCrypt
This is a basic repo of the RawCrypt.com code. 

This website is built upon the Laravel framework and as such, I am unable to upload all 14k files involved in make the site function the way it does.

The included code is the basis of how the website functions. 

The code is simple. Home page is the Index.blade.php file and once any encryption info is added to the TEXTAREA it then sent to the HomeController.php file and accesses the GET_encrypt_it function. 
After this processes, it is then stored within the DB as a Base64 string and then RETURNS to the INDEX page as the Base64 value along with a unique URL.

As shown here. DB::table('encrypted')->insert( ['url_link' => $url, 'content' => $encrypted_content, 'access_count' => 0] ); There is no place where the PassKey is stored anywhere in the DB.

When the user is ready to Decrypt the database record, they access the unique URL and enter in the passkey.
Once done, the bottom TEXTAREA shows the decrypted data. 
