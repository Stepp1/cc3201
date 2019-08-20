44
<?php
try {
    $pdo = new PDO('pgsql:dbname=cc3201;host=localhost;port=5432;user=visit;password=***');
    echo "PDO connection object created\n";
    echo "<br>";

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

    echo "consulta preparada\n";
    echo "<br>";

    $stmt->execute([$pais, $anho]);
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
