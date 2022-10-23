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

class SleepWakeupInvoke
{
    private array $users;
    private $fh;

    public function __construct(array $users)
    {
        $this->setUsers($users);
    }

    /**
     * @return array
     */
    public function getUsers(): array
    {
        foreach ($this->users as $user)
            echo $user['name'] . " weight " . $user['weight'] . PHP_EOL;
        return $this->users;
    }

    /**
     * @param array $users
     */
    public function setUsers(array $users): void
    {
        $this->users = $users;
    }

    public function sortMe($key)
    {
        echo "Sort by " . $key . ":" . PHP_EOL;
        usort($this->users, new CompareCB($key));
    }
//просто для метода __wakeup при unserialize создается файлхэндлер
    private function openFile($filename)
    {
        $this->fh = fopen($filename,"a+");
    }
    public function __sleep()
    {
        return ['users'];
    }

    public function __wakeup()
    {
        $this->openFile("test.txt");
    }
}

$users = [
    ['name' => 'Petrov', 'weight' => 102],
    ['name' => 'Ivanov', 'weight' => 95],
    ['name' => 'Sidorov', 'weight' => 101]
];

$usersObj = new SleepWakeupInvoke($users);
$usersObj->sortMe('name');
$usersObj->getUsers();
$usersObj->sortMe('weight');
$usersObj->getUsers();
$a = serialize($usersObj);
var_dump($a);
$usersObj = unserialize($a);



