<?php
$d = new Dbus( Dbus::BUS_SYSTEM );
$d->addWatch( 'org.freedesktop.Hal.Device' );
$d->addWatch( 'nl.derickrethans.Interface' );

$b = 0;

do
{
	$s = $d->waitLoop( 1000 );
	if ( !$s ) continue;

	if ( $s->matches( 'org.freedesktop.Hal.Device', 'Condition' ) )
	{
		$b = $s->getData()->getData();
		if ( in_array( 'brightness-up', $b ) ||
			in_array( 'brightness-down', $b ) )
		{
			echo "Brightness changed\n";
		}
	}
	else if ( $s->matches( 'nl.derickrethans.Interface', 'TestSignal' ) )
	{
		var_dump( $s->getData() );
	}
}
while ( true );
?>
