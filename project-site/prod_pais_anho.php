
<?php
try {
    $pdo = new PDO('pgsql:dbname=cc3201;host=localhost;port=5432;user=visit;password=visitpass');
    echo "PDO connection object created\n";
    echo "<br>";

    $fuente = $_GET['input'];

    $sql = 'Select p.name
FROM plant p
Where id_plant in (
Select q.id_plant
From location q
where q.latitude between 0 and 90)
and id_plant not in (
Select q.id_plant
from fuel q
where q.fuel = ?)
order by p.name asc;';


    $stmt = $pdo->prepare($sql);

    echo "consulta preparada\n";
    echo "<br>";

    $stmt->execute($fuente);
    echo "execute\n";
    echo "<br>";


    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        echo $row;
    }
}
catch(PDOException $e)
{
    echo $e->getMessage();
}