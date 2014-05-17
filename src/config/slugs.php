<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Model's Default Name/ Title Field
	|--------------------------------------------------------------------------
	|
	| The default model field that repesents the model's name or title, that
	| the slug will be created from. Can be a derived attribute with a
	| corresponding getFooAttribute() accessor method.
	|
	| Set a common field name here and optionally override for individual models.
	|
	*/

	'title_field' => 'name',

	/*
	|--------------------------------------------------------------------------
	| Model's Default Slug Field
	|--------------------------------------------------------------------------
	|
	| The default model field where the slug will be saved.
	| There should not be a corresponding setFooAttribute() mutator method, as
	| this could interfere with the functionality.
	|
	| Set a common field name here and optionally override for individual models.
	|
	*/

	'slug_field' => 'slug',

	/*
	|--------------------------------------------------------------------------
	| Model's Default Disambiguation Field
	|--------------------------------------------------------------------------
	|
	| The default model field that represents the model's disambiguation field,
	| that will be used in the slug if it is not unique.
	| 
	| There should not be a corresponding setFooAttribute() mutator method, as
	| this could interfere with the functionality.
	|
	| Set a common field name here and optionally override for individual models.
	|
	| If false, the disambiguation will be saved in the slug field, separated by
	| the delimiter specified in 'disambig_delimiter'.
	|
	*/

	'disambig_field' => 'disambig',

	/*
	|--------------------------------------------------------------------------
	| Store Model's Disambiguation in Separate Field
	|--------------------------------------------------------------------------
	|
	| The model field where the slugged disambiguation will be saved.
	| There should not be a corresponding setFooAttribute() mutator method, as
	| this could interfere with the functionality.
	|
	| Set a common field name here and optionally override for individual models.
	|
	| If false, the disambiguation will be saved in the slug field, separated by '/'.
	|
	*/

	'disambig_slug_field' => 'disambig_slug',

	/*
	|--------------------------------------------------------------------------
	| Disambiguation Delimiter
	|--------------------------------------------------------------------------
	|
	| The method used to display the slug and disambiguation fields together.
	| The slug and disambiguation will always be stored in the database
	| separated by '|' (pipe character).
	|
	| Options are:
    | - '/': URL slash, e.g. "Slug/Disambig"
	| - '()': Round Brackets, e.g. "Slug (Disambig)"
	| - '-': Dash, e.g. "Slug - Disambig"
	|
	| Any other value will default to URL slash.
	|
	| Whichever value is used, the delimiter character(s) will be stripped
	| from within the slug and disambig values themselves.
	|
	*/

	'disambig_delimiter' => '/',

	/*
	|--------------------------------------------------------------------------
	| Slug Letter Case
	|--------------------------------------------------------------------------
	|
	| The letter case the slug will be converted into.
	|
	| Options are:
    | - 'title': Title Case, e.g. "My Page Name"
	| - 'lower': Lower Case, e.g. "my page name"
	| - 'upper': Upper Case, e.g. "MY PAGE NAME"
	|
	| Any other value will leave the case unchanged.
	|
	*/

	'case' => '',

	/*
	|--------------------------------------------------------------------------
	| Slug Delimiter
	|--------------------------------------------------------------------------
	|
	| The delimiter which will be used for the slug to replace spaces.
	|
	| Can theoretically be anything, but likely options are:
    | - '-': Dash/ Hyphen, e.g. "My-Page-Name"
	| - '_': Underscore,   e.g. "My_Page_Name"
	| - ' ': Space,        e.g. "My Page Name" (will be URL encoded to %20)
	| - '+': Plus,         e.g. "My+Page+Name"
	|
	*/

	'delimiter' => '_',

	/*
	|--------------------------------------------------------------------------
	| Maximum Slug Length
	|--------------------------------------------------------------------------
	|
	| The maximum length of the generated slug (a positive integer).
	| If anything other than a positive integer, will be ignored (the generated
	| slug will be however long the title field is after processing.)
	|
	*/

	'max_length' => null,

	/*
	|--------------------------------------------------------------------------
	| Change Slug on Update
	|--------------------------------------------------------------------------
	|
	| Whether an existing slug will be modified if the model's title
	| field is updated after it is first saved. True/ false.
	|
	*/

	'on_update' => true,

	/*
	|--------------------------------------------------------------------------
	| Reserved Word Blacklist
	|--------------------------------------------------------------------------
	|
	| An array of strings which cannot be used as slugs, i.e. existing route
	| names or other reserved words which would interfere with functionality.
	|
	*/

	'blacklist' => [],

	/*
	|--------------------------------------------------------------------------
	| Force or Handle Uniqueness of Slugs
	|--------------------------------------------------------------------------
	|
	| How to handle duplicate slugs. 
	|
	| Options are:
    | - 'disambig': Use the Disambiguable ModelAbility. Must be separately
    |   configured. If not configured, will default to allowing duplicates.
	| - 'increment': Automatically append a separator and an incrementing digit
	|   to slugs, e.g. "my-page-name", "my-page-name-1", "my-page-name-2"
	|
	| Any other value will allow creation of duplicate slugs.
	|
	*/

	'unique' => 'increment',

	/*
	|--------------------------------------------------------------------------
	| s
	|--------------------------------------------------------------------------
	|
	| s
	|
	*/

	's' => 's',

	);
