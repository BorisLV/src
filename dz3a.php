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
    private $file;

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

    public function __sleep()
    {
        return ['users'];
    }

    public function __wakeup()
    {

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




