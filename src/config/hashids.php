<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Custom Salt
	|--------------------------------------------------------------------------
	|
	| Hashids supports personalizing your hashes by accepting a salt value. If
	| you don't want others to be able decrypt your hashes, provide a unique
	| string.
	|
	| If you change the salt, the generated hash will change.
	|
	| Default: Config::get('app.key')
	| Set to '' use no salt and allow Hashids to be decrypted by others.
	|
	*/

	'salt' => Config::get('app.key'),

	/*
	|--------------------------------------------------------------------------
	| Minimum Length
	|--------------------------------------------------------------------------
	|
	| By default, hashes are going to be as short as possible. You can also set
	| the minimum hash length to mask how large the number behind the hash is.
	|
	| Default: 0
	|
	*/

	'length' => 8,

	/*
	|--------------------------------------------------------------------------
	| Custom Alphabet
	|--------------------------------------------------------------------------
	|
	| The possible characters that can be used to generate the hash.
	|
	| The default alphabet contains all lowercase and uppercase letters and numbers.
	| Your custom alphabet should contain at least 16 characters.
	|
	| Default: '' --> abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890
	|
	*/

	'alphabet' => '',
	
);