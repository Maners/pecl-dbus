<?php
$d = new Dbus( Dbus::BUS_SESSION, true );
$d->requestName( 'nl.derickrethans.test' );
$s = new DbusSignal(
	$d, 
	'/nl/derickrethans/SignalObject', 
	'nl.derickrethans.Interface', 
	'TestSignal'
);
$s->send( "ze data", new DBusArray( Dbus::STRING, array( 'one', 'two' ) ) );
?>
