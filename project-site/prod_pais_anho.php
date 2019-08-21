
<?php
try {
    $pdo = new PDO('pgsql:dbname=cc3201;host=localhost;port=5432;user=visit;password=visitpass');

    $fuente = $_GET['input'];

    $sql = 'Select p.name,l1.country ,prod.electricity_generation
    FROM plant p, production prod, location l1
    Where p.id_plant in (
    Select q.id_plant
    From location q
    where q.latitude between 0 and 90)
    and p.id_plant in (
    Select q.id_plant
    from fuel q
    where q.fuel = :fuel)
    AND prod.id_plant = p.id_plant
    AND p.id_plant = l1.id_plant
    order by prod.electricity_generation desc
    LIMIT 50';


    $stmt = $pdo->prepare($sql);


    $stmt->bindValue(':fuel', $fuente);
    $stmt->execute();


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
