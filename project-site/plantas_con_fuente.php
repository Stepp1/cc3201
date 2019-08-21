
<?php
try {
    $pdo = new PDO('pgsql:dbname=cc3201;host=localhost;port=5432;user=visit;password=visitpass');

    $pais = $_GET['pais'];
    $anho = $_GET['anho'];

    $sql = 'SELECT p.id_plant, c.country_long, e.electricity_generation
FROM plant p 
Join location l
on (p.id_plant = l.id_plant)
Join country c
on (c.country = l.country)
Join production e
on (p.id_plant = e.id_plant)
where e.electricity_generation > 15000
and e.year= ?
and
c.country = ?
order by e.electricity_generation desc;';


    $stmt = $pdo->prepare($sql);


    $stmt->execute([$anho,$pais]);


    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        print_r($row);
	echo "<br>";
    }
}
catch(PDOException $e)
{
    echo $e->getMessage();
}
