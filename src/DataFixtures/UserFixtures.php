<?php declare(strict_types=1);

namespace App\DataFixtures;


use App\Entity\User;

class UserFixtures extends AbstractFixture
{
    public function execute(): void
    {
        $user = new User(
            'user@example.com',
            '$argon2i$v=19$m=65536,t=4,p=1$WXRuUVVKMjUwS2psS3h6OQ$JVZ8DyPMQHrFpjuSzftz/alIPgRb+ZSrl57MHAU6Zh0',
        'John',
            'Travolta'
        );

        $this->saveEntities([$user]);
    }
}