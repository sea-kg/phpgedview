<?php
$tables = array(

PHPGEDVIEW_DB_PREFIX.'gedcom' => "
	g_id I4 PRIMARY,
	g_content_id I4,
	g_name C(255),
	g_path C(255),
	g_config C(255),
	g_privacy C(255),
	g_commonsurnames X
",

PHPGEDVIEW_DB_PREFIX.'individuals' => "
	i_id C(250) PRIMARY,
	i_file I4,
	i_rin C(30),
	i_name C(255),
	i_isdead I1,
	i_GEDCOM X,
	i_letter C(5),
	i_surname C(100)
",

PHPGEDVIEW_DB_PREFIX.'families' => "
	f_id C(250) PRIMARY,
	f_file I4,
	f_husb C(255),
	f_wife C(255),
	f_chil X,
	f_GEDCOM X,
	f_numchil I1
",

PHPGEDVIEW_DB_PREFIX.'sources' => "
	s_id C(250) PRIMARY,
	s_file I4,
	s_name C(255),
	s_GEDCOM X
",

PHPGEDVIEW_DB_PREFIX.'other' => "
	o_id C(250) PRIMARY,
	o_file I4,
	o_type C(20),
	o_GEDCOM X
",

PHPGEDVIEW_DB_PREFIX.'names' => "
	n_gid C(250) PRIMARY,
	n_file I4,
	n_type C(10),
	n_letter C(5),
	n_surname C(100),
	n_type C(10)
",

PHPGEDVIEW_DB_PREFIX.'dates' => "
	d_day I,
	d_month C(15),
	d_mon I,
	d_year I,
	d_datestamp D,
	d_fact I,
	d_gid C(255),
	d_file I4,
	d_type C(10)
",

PHPGEDVIEW_DB_PREFIX.'blocks' => "
	b_id I4 PRIMARY,
	b_username C(100),
	b_location C(30),
	b_order I,
	b_name C(255),
	b_config X
",

PHPGEDVIEW_DB_PREFIX.'favorites' => "
	fv_id I4 PRIMARY,
	fv_username C(30),
	fv_gid C(10),
	fv_type C(10),
	fv_file C(100),
	fv_url C(255),
	fv_title C(255),
	fv_note X
",

PHPGEDVIEW_DB_PREFIX.'messages' => "
	m_id I4 PRIMARY,
	m_from C(255),
	m_to C(30),
	m_subject C(255),
	m_note X,
	m_created C(20)
",

PHPGEDVIEW_DB_PREFIX.'news' => "
	n_id I4 PRIMARY,
	n_username C(100),
	n_date I4,
	n_title C(255),
	n_note X
",

PHPGEDVIEW_DB_PREFIX.'places' => "
	p_id I4 PRIMARY,
	p_place C(150),
	p_level I4,
	p_parent_id I4,
	p_file I4
",

PHPGEDVIEW_DB_PREFIX.'placelinks' => "
	pl_p_id I4 PRIMARY,
	pl_gid C(30),
	pl_file I4
",

PHPGEDVIEW_DB_PREFIX.'users' => "
	u_id I4 PRIMARY,
	u_username C(30),
	u_GEDCOMid X,
	u_rootid X
",

PHPGEDVIEW_DB_PREFIX.'temple_code' => "
	tc_id I4 PRIMARY AUTO,
	tc_name C(5),
	tc_title C(100),
	tc_memo X
",

PHPGEDVIEW_DB_PREFIX.'status_code' => "
	sc_id I4 PRIMARY AUTO,
	sc_name C(20),
	sc_title C(100)
"
);

global $gBitInstaller;

$gBitInstaller->makePackageHomeable('phpgedview');

foreach( array_keys( $tables ) AS $tableName ) {
	$gBitInstaller->registerSchemaTable( PHPGEDVIEW_PKG_NAME, $tableName, $tables[$tableName] );
}

$indices = array (
	'id_rin_idx' => array( 'table' => PHPGEDVIEW_DB_PREFIX.'individuals', 'cols' => 'i_rin', 'opts' => array( 'UNIQUE' ) ),
	'id_surname_idx' => array( 'table' => PHPGEDVIEW_DB_PREFIX.'individuals', 'cols' => 'i_surname', 'opts' => NULL ),
	'p_place_idx' => array( 'table' => PHPGEDVIEW_DB_PREFIX.'places', 'cols' => 'p_place', 'opts' => NULL ),
	'tc_name_idx' => array( 'table' => PHPGEDVIEW_DB_PREFIX.'temple_code', 'cols' => 'tc_name', 'opts' => array( 'UNIQUE' ) ),
);
$gBitInstaller->registerSchemaIndexes( PHPGEDVIEW_PKG_NAME, $indices );

$gBitInstaller->registerPackageInfo( PHPGEDVIEW_PKG_NAME, array(
	'description' => "phpgedview genealogy data management interface.",
	'license' => '<a href="http://www.gnu.org/licenses/licenses.html#LGPL">LGPL</a>',
	'version' => '0.1',
	'state' => 'beta',
	'dependencies' => 'html',
) );

// ### Default Preferences
$gBitInstaller->registerPreferences( PHPGEDVIEW_PKG_NAME, array(
	array(PHPGEDVIEW_PKG_NAME,'pgv_session_time','7200'),
	array(PHPGEDVIEW_PKG_NAME,'calendar_format','gregorian'),
	array(PHPGEDVIEW_PKG_NAME,'default_pedigree_generations','4'),
	array(PHPGEDVIEW_PKG_NAME,'max_pedigree_generations','10'),
	array(PHPGEDVIEW_PKG_NAME,'max_descendancy_generations','15'),
	array(PHPGEDVIEW_PKG_NAME,'use_RIN','n'),
	array(PHPGEDVIEW_PKG_NAME,'pedigree_root_id','I1'),
	array(PHPGEDVIEW_PKG_NAME,'gedcom_prefix_id','I'),
	array(PHPGEDVIEW_PKG_NAME,'source_prefix_id','S'),
	array(PHPGEDVIEW_PKG_NAME,'repo_prefix_id','R'),
	array(PHPGEDVIEW_PKG_NAME,'fam_prefix_id','F'),
	array(PHPGEDVIEW_PKG_NAME,'media_prefix_id','M'),
) );

// ### Default UserPermissions
$gBitInstaller->registerUserPermissions( PHPGEDVIEW_PKG_NAME, array(
	array('bit_p_view_phpgedview', 'Can view gedcom data', 'registered', 'phpgedview'),
	array('bit_p_edit_phpgedview', 'Can edit gedcom data', 'registered', 'phpgedview'),
	array('bit_p_admin_phpgedview', 'Can admin phpgedview interface', 'editors', 'phpgedview')
) );

$gBitInstaller->registerSchemaDefault( PHPGEDVIEW_PKG_NAME, array(
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('ABA', 'Aba, Nigeria')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('ACCRA', 'Accra, Ghana')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('ADELA', 'Adelaide, Australia')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('ALBUQ', 'Albuquerque, New Mexico')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('ANCHO', 'Anchorage, Alaska')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('SAMOA', 'Apia, Samoa')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('ASUNC', 'Asuncion, Paraguay')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('ATLAN', 'Atlanta, Georgia')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('SWISS', 'Bern, Switzerland')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('BOGOT', 'Bogota, Columbia')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('BILLI', 'Billings, Montana')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('BIRMI', 'Birmingham, Alabama')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('BISMA', 'Bismarck, North Dakota')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('BOISE', 'Boise, Idaho')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('BOSTO', 'Boston, Massachusetts')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('BOUNT', 'Bountiful, Utah')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('BRISB', 'Brisbane, Australia')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('BROUG', 'Baton Rouge, Louisiana')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('BAIRE', 'Buenos Aires, Argentina')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('CAMPI', 'Campinas, Brazil')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('CARAC', 'Caracas, Venezuela')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('ALBER', 'Cardston, Alberta, Canada')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('CHICA', 'Chicago, Illinois')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('CIUJU', 'Ciudad Juarez, Mexico')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('COCHA', 'Cochabamba, Bolivia')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('COLJU', 'Colonia Juarez, Mexico')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('COLSC', 'Columbia, South Carolina')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('COLUM', 'Columbus, Ohio')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('COPEN', 'Copenhagen, Denmark')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('CRIVE', 'Columbia River, Washington')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('DALLA', 'Dallas, Texas')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('DENVE', 'Denver, Colorado')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('DETRO', 'Detroit, Michigan')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('EDMON', 'Edmonton, Alberta, Canada')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('EHOUS', 'ENDOWMENT HOUSE')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('FRANK', 'Frankfurt am Main, Germany')",  // There's also a Frankfurt an der Oder in Germany
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('FREIB', 'Freiburg, Germany')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('FRESN', 'Fresno, California')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('FUKUO', 'Fukuoka, Japan')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('GUADA', 'Guadalajara, Mexico')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('GUATE', 'Guatemala City, Guatemala')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('GUAYA', 'Guayaquil, Ecuador')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('HAGUE', 'The Hague, Netherlands')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('HALIF', 'Halifax, Nova Scotia, Canada')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('NZEAL', 'Hamilton, New Zealand')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('HARTF', 'Hartford, Connecticut')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('HELSI', 'Helsinki, Finland')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('HERMO', 'Hermosillo, Mexico')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('HKONG', 'Hong Kong')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('HOUST', 'Houston, Texas')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('IFALL', 'Idaho Falls, Idaho')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('JOHAN', 'Johannesburg, South Africa')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('JRIVE', 'Jordan River, Utah')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('KIEV', 'Kiev, Ukraine')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('KONA', 'Kona, Hawaii')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('HAWAI', 'Laie, Hawaii')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('LVEGA', 'Las Vegas, Nevada')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('LIMA', 'Lima, Peru')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('LOGAN', 'Logan, Utah')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('LONDO', 'London, England')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('LANGE', 'Los Angeles, California')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('LOUIS', 'Louisville, Kentucky')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('LUBBO', 'Lubbock, Texas')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('MADRI', 'Madrid, Spain')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('MANIL', 'Manila, Philippines')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('MANTI', 'Manti, Utah')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('MEDFO', 'Medford, Oregon')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('MELBO', 'Melbourne, Australia')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('MEMPH', 'Memphis, Tennessee')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('MERID', 'Merida, Mexico')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('ARIZO', 'Mesa, Arizona')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('MEXIC', 'Mexico City, Mexico')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('MONTE', 'Monterrey, Mexico')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('MNTVD', 'Montevideo, Uruguay')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('MONTI', 'Monticello, Utah')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('MONTR', 'Montreal, Quebec, Canada')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('MTIMP', 'Mt. Timpanogos, Utah')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('NASHV', 'Nashville, Tennessee')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('NAUV2', 'Nauvoo, Illinois (new)')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('NAUVO', 'Nauvoo, Illinois (original)')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('NBEAC', 'Newport Beach, California')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('NYORK', 'New York, New York')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('NUKUA', 'Nuku''Alofa, Tonga')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('OAKLA', 'Oakland, California')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('OAXAC', 'Oaxaca, Mexico')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('OGDEN', 'Ogden, Utah')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('OKLAH', 'Oklahoma City, Oklahoma')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('ORLAN', 'Orlando, Florida')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('PALEG', 'Porto Alegre, Mexico')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('PALMY', 'Palmyra, New York')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('PAPEE', 'Papeete, Tahiti')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('PERTH', 'Perth, Australia')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('PORTL', 'Portland, Oregon')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('POFFI', 'PRESIDENT''S OFFICE')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('PREST', 'Preston, England')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('PROVO', 'Provo, Utah')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('RALEI', 'Raleigh, North Carolina')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('RECIF', 'Recife, Brazil')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('REDLA', 'Redlands, California')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('REGIN', 'Regina, Saskatchewan, Canada')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('RENO', 'Reno, Nevada')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('SACRA', 'Sacramento, California')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('SLAKE', 'Salt Lake City, Utah')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('SANTO', 'San Antonio, Texas')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('SDIEG', 'San Diego, California')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('SJOSE', 'San Jose, Costa Rica')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('SANTI', 'Santiago, Chile')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('SDOMI', 'Santo Domingo, Dom. Rep.')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('SPAUL', 'Sao Paulo, Brazil')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('SEATT', 'Seattle, Washington')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('SEOUL', 'Seoul, Korea')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('SNOWF', 'Snowflake, Arizona')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('SPOKA', 'Spokane, Washington')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('SGEOR', 'St. George, Utah')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('SLOUI', 'St. Louis, Missouri')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('SPMIN', 'St. Paul, Minnesota')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('STOCK', 'Stockholm, Sweden')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('SUVA', 'Suva, Fiji')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('SYDNE', 'Sydney, Australia')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('TAIPE', 'Taipei, Taiwan')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('TAMPI', 'Tampico, Mexico')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('TOKYO', 'Tokyo, Japan')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('TORNO', 'Toronto, Ontario, Canada')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('TGUTI', 'Tuxtla Gutierrez, Mexico')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('VERAC', 'Veracruz, Mexico')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('VERNA', 'Vernal, Utah')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('VILLA', 'Villa Hermosa, Mexico')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('WASHI', 'Washington, DC')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."temple_code`(`tc_name`, `tc_title`) VALUES ('WINTE', 'Winter Quarters, Nebraska')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."status_code`(`sc_name`, `sc_title`) VALUES ('CHILD', 'Died as a child: exempt')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."status_code`(`sc_name`, `sc_title`) VALUES ('INFANT', 'Died as an infant: exempt')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."status_code`(`sc_name`, `sc_title`) VALUES ('STILLBORN', 'Stillborn: exempt')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."status_code`(`sc_name`, `sc_title`) VALUES ('BIC', 'Born in the covenant')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."status_code`(`sc_name`, `sc_title`) VALUES ('SUBMITTED', 'Submitted but not yet cleared')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."status_code`(`sc_name`, `sc_title`) VALUES ('UNCLEARED', 'Uncleared: insufficient data')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."status_code`(`sc_name`, `sc_title`) VALUES ('CLEARED', 'Cleared but not yet completed')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."status_code`(`sc_name`, `sc_title`) VALUES ('COMPLETED', 'Completed; date unknown')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."status_code`(`sc_name`, `sc_title`) VALUES ('PRE-1970', 'Completed before 1970; date not available')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."status_code`(`sc_name`, `sc_title`) VALUES ('CANCELLED', 'Sealing cancelled (divorce)')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."status_code`(`sc_name`, `sc_title`) VALUES ('DNS', 'Do Not Seal: unauthorized')",
"INSERT INTO `".PHPGEDVIEW_DB_PREFIX."status_code`(`sc_name`, `sc_title`) VALUES ('DNS/CAN', 'Do Not Seal, previous sealing cancelled')",
) );

?>
