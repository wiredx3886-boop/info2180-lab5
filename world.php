<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$country = $_GET['country'] ?? '';
$lookup = $_GET['lookup'] ?? '';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
$isCityLookup = $lookup === 'cities';

if ($isCityLookup) {
  $stmt = $conn->prepare(
    "SELECT cities.name, cities.district, cities.population
     FROM cities
     JOIN countries ON cities.country_code = countries.code
     WHERE countries.name = :country"
  );
} else {
  $stmt = $conn->prepare("SELECT * FROM countries WHERE name = :country");
}
$stmt->execute(['country' => $country]);

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<table>
  <thead>
    <tr>
<?php if ($isCityLookup): ?>
      <th>City Name</th>
      <th>District</th>
      <th>Population</th>
<?php else: ?>
      <th>Country Name</th>
      <th>Continent</th>
      <th>Independence Year</th>
      <th>Head of State</th>
<?php endif; ?>
    </tr>
  </thead>
  <tbody>
<?php foreach ($results as $row): ?>
    <tr>
<?php if ($isCityLookup): ?>
      <td><?= htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?></td>
      <td><?= htmlspecialchars($row['district'], ENT_QUOTES, 'UTF-8'); ?></td>
      <td><?= htmlspecialchars((string) $row['population'], ENT_QUOTES, 'UTF-8'); ?></td>
<?php else: ?>
      <td><?= htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?></td>
      <td><?= htmlspecialchars($row['continent'], ENT_QUOTES, 'UTF-8'); ?></td>
      <td><?= htmlspecialchars((string) $row['indep_year'], ENT_QUOTES, 'UTF-8'); ?></td>
      <td><?= htmlspecialchars($row['head_of_state'], ENT_QUOTES, 'UTF-8'); ?></td>
<?php endif; ?>
    </tr>
<?php endforeach; ?>
  </tbody>
</table>
