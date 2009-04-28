<?php
$d = new Dbus( Dbus::BUS_SESSION, true );
$n = $d->createProxy( "com.Skype.API", "/com/Skype", "com.Skype.API");
$n->Invoke( "NAME PHP" );
$n->Invoke( "PROTOCOL 7" );
$chatId = $n->Invoke( "CHAT CREATE derickrethans" );
list( $ignore, $id, $stuff, $stuff2 ) = explode( " ", $chatId[0] );
$n->Invoke( "OPEN CHAT $id" );

while ( true )
{
	$r = $n->Invoke( "GET CHAT $id RECENTCHATMESSAGES" );
	list( $ignore, $dummy, $dummy, $messageIds ) = explode( ' ', $r[0], 4 );
	foreach( explode( ", ", $messageIds ) as $messageId )
	{
		$data = $n->Invoke( "GET CHATMESSAGE $messageId FROM_HANDLE" );
		list( $a, $b, $c, $name ) = explode( ' ', $data[0], 4 );
		$data = $n->Invoke( "GET CHATMESSAGE $messageId BODY" );
		list( $a, $b, $c, $body ) = explode( ' ', $data[0], 4 );
		echo $name, ": ", $body, "\n";
		$n->Invoke( "SET CHATMESSAGE $messageId SEEN" );
	}
	sleep( 30 );
}
?>

