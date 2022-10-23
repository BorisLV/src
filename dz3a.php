<?php
class CompareCB
{
    protected string $key;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function __invoke($a, $b): int
    {
        return $a[$this->key] <=> $b[$this->key];
    }
}

$users = [
    ['name' => 'Petrov', 'weight' => 102],
    ['name' => 'Ivanov', 'weight' => 95],
    ['name' => 'Sidorov', 'weight' => 101]
];

echo "сортировка по имени: " . PHP_EOL;
usort($users, new CompareCB('name'));

foreach ($users as $user)
    echo $user['name'] . " weight " . $user['weight'] . PHP_EOL;

echo "сортировка по весу: " . PHP_EOL;
usort($users, new CompareCB('weight'));

foreach ($users as $user)
    echo $user['name'] . " weight " . $user['weight'] . PHP_EOL;