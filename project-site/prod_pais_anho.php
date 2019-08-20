
<?php
try {
    $pdo = new PDO('pgsql:dbname=cc3201;host=localhost;port=***;user=visit;password=***');
    echo "PDO connection object created\n";
    echo "<br>";

    $fuente = $_GET['input'];

    $sql = 'Select p.name
    FROM plant p, production prod
    Where p.id_plant in (
    Select q.id_plant
    From location q
    where q.latitude between 0 and 90)
    and p.id_plant not in (
    Select q.id_plant
    from fuel q
    where q.fuel = :fuel)
    AND prod.id_plant = p.id_plant
    order by prod.electricity_generation, p.name asc
    LIMIT 50';


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
