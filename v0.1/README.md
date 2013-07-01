Warning: Sorry, for now the README is only in italian.
XClan
=======
Se sei interessato ad usare la classe XClan per ottenere tutte le informazioni riguardo un team o una community includere il file xclan.php nel tuo file php.<br />
<code>include "xclan.php";</code><br />
Una volta fatto inizializzare la clan con il nome del team a cui sei interessato:<br />
<code>$clan = new XClan("team_name");</code><br />
Ecco fatto! Ora avete accesso a tutte le informazioni riguardo quella community o clan!<br /><br />

Metodi:

setClan
------
Params: <br />
$clan: Permette di impostare il nome del team anche fuori dal costruttore<br />
Return: <br />
Nulla<br />

getTeamMembers
------
Params: <br />
$force: Costringe a rileggere i dati dall'XML. Se impostato su false e la funzione è già stata usata precendemente sarà ritornato lo stesso array <br />
Return: <br />
Un array contentene i membri della community/clan oppure false se il team non è stato impostato. <br />

getTeamName, getTeamType, getFoundedTime, getTeamLogo, getTeamSite, getTeamDescription, getTeamNMembers
------
Params: <br />
Nessuno <br />
Return: <br />
Ritornano rispettivamente: il nome del team, il tipo di team, la data di creazione, il logo, il sito, la descrizione e il numero di membri.
<br />