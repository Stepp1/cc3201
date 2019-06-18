
<?php
try {
    $pdo = new PDO('pgsql:dbname=cc3201; host=localhost; port=5432; user=visit; password=visitpass');
    echo "PDO connection object created\n";
    echo "<br>";

    $pais = $_GET['input'];

    $sql = 'select O.country_long, U.cantidad, U.fuel, O.elec_generation
from(
select b2.country, b2.cantidad, f1.fuel
FROM
(select x.country, max(x.cantidad) as cantidad 
	FROM(
	Select l.country , f.fuel ,count(f.id_plant) as cantidad
		FROM location l, fuel f
		WHERE l.id_plant=f.id_plant
		group by l.country, f.fuel
	) x
	group by x.country
) b2,
(Select l3.country , f3.fuel ,count(f3.id_plant) as cantidad
	FROM location l3, fuel f3
	where l3.id_plant=f3.id_plant
	group by l3.country, f3.fuel) f1
where b2.cantidad = f1.cantidad
and b2.country = f1.country
) U,
(select a.country_long, a.country, avg(b.electricity_generation) as elec_generation
from country a, production b, location c
Where a.country = c.country
and b.id_plant = c.id_plant
and O.country_long= ?
group by a.country_long, a.country) O
where U.country=O.country';


    $stmt = $pdo->prepare($sql, [PDO::ATTR_CURSOR=>PDO::CURSOR_SCROLL]);

    echo "consulta preparada\n";
    echo "<br>";

    $stmt->execute($pais);
    echo "execute\n";
    echo "<br>";


    $result = $stmt->fetch();


    foreach ($result as $row)
    {
        echo $row . "\r\n";
    }
}
catch(PDOException $e)
{
    echo $e->getMessage();
}