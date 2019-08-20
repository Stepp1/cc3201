
<?php
try {
    $pdo = new PDO('pgsql:dbname=cc3201;host=localhost;port=***;user=visit;password=***');
    echo "PDO connection object created\n";
    echo "<br>";

    $fuente = $_GET['input'];

    $sql = 'SELECT p.name,l1.country ,prod.electricity_generation
    FROM plant p, production prod, location l1
    WHERE p.id_plant IN (
    SELECT q.id_plant
    FROM location q
    WHERE q.latitude BETWEEN 0 AND 90)
    AND p.id_plant IN (
    SELECT q.id_plant
    FROM fuel q
    WHERE q.fuel = :fuel)
    AND prod.id_plant = p.id_plant
    AND p.id_plant = l1.id_plant
    ORDER BY prod.electricity_generation DESC
    LIMIT 50;';


    $stmt = $pdo->prepare($sql);

    echo "consulta preparada\n";
    echo "<br>";

    $stmt->bindValue(':fuel', $fuente);
    $stmt->execute();
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
