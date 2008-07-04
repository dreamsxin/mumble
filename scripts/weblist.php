<html>
<head>
<title>Userlist</title>
</head>
<body>
<?php

Ice_loadProfile();

try {
  $base = $ICE->stringToProxy("Meta:tcp -h 127.0.0.1 -p 6502");
  $meta = $base->ice_checkedCast("::Murmur::Meta");

  $servers = $meta->getBootedServers();
  $default = $meta->getDefaultConf();
  foreach($servers as $s) {
    $name = $s->getConf("registername");
    if (! $name) {
      $name =  $default["registername"];
    }
    echo "<h1>SERVER #" . $s->id() . " " .$name ."</h1>\n";
    echo "<table><tr><th>Name</th><th>Channel</th></tr>\n";

    $channels = $s->getChannels();
    $players = $s->getPlayers();

    foreach($players as $id => $state) {
      $chan = $channels[$state->channel];
      echo "<tr><td>".$state->name."</td><td>".$chan->name."</td></tr>\n";
    }
    echo "</table>\n";
  }
} catch (Ice_LocalException $ex) {
  print_r($ex);
}

?>
</body>
</html>
