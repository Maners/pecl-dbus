<?php
$d = new Dbus( Dbus::BUS_SESSION, true );
$n = new DbusObject( $d, "com.Skype.API", "/com/Skype", "com.Skype.API");
var_dump( $n->Invoke( "NAME PHP" ) );
var_dump( $n->Invoke( "PROTOCOL 7" ) );
$chatId = $n->Invoke( "CHAT CREATE derickrethans" );
list( $ignore, $id, $stuff, $stuff2 ) = explode( " ", $chatId[0] );
var_dump( $n->Invoke( "OPEN CHAT $id" ) );

class testClass {
	static function notify($a) {
		global $n;

		var_dump( $a );
		@list( $a, $b, $c ) = explode( ' ', $a, 3 );
		if ( $a === "CHATMESSAGE" )
		{
			$data = $n->Invoke( "GET CHATMESSAGE $b BODY" );
			list( $a, $b, $c, $body ) = explode( ' ', $data[0], 4 );
			echo $body, "\n";
		}
	}
}

$d->registerObject( '/com/Skype/Client', 'com.Skype.API.Client', 'testClass' );

do {
	$s = $d->waitLoop( 1000 );
}
while ( true );
?>
