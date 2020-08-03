<?php


require_once '../vendor/autoload.php';
require_once '../config/eloquent.php';

use \Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function telegram()
    {
        return $this->hasOne(Telegram::class);
    }
    public function publication()
    {
        return $this->hasMany(Publication::class);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
class Telegram extends Model
{
}
class Publication extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
class Tag extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
class Tag_User extends Model{}

$faker = Faker\Factory::create();


for($i = 0; $i < 25;$i++){
    $user = new User();
    $telegram = new Telegram();
    $user->email = $faker->email;
    $user->password = $faker->password;
    $user->save();
    $telegram->telegram = '@'.$faker->name;
    $telegram->user_id = $user->id;
    $telegram->save();
}
for($i = 0; $i < 50;$i++){
    $publication = new Publication();
    $publication->author = $faker->name;
    $publication->name = $faker->title;
    $publication->text = $faker->text;
    $publication->user_id = rand(3,27);
    $publication->save();
    $tag = new Tag();
    $tag->name = $faker->name;
    $tag->save();
}





//foreach (User::all() as $user){
//    echo "<h1>{$user->email}</h1>";
//    foreach ($user->publication as $publication){
//        echo "<p>{$publication->author}</p>";
//        echo "<p>{$publication->name}</p>";
//        echo "<p>{$publication->text}</p>";
//    }
//}
/**
 *
create schema sandbox;



CREATE TABLE `users` (
`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
`email` varchar(255) NOT NULL,
`password` varchar(255) NOT NULL,
`created_at` datetime NOT NULL,
`updated_at` datetime NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1

CREATE TABLE `telegrams` (
`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
`telegram` varchar(255) NOT NULL,
`user_id` bigint(20) unsigned NOT NULL,
`created_at` datetime NOT NULL,
`updated_at` datetime DEFAULT NULL,
PRIMARY KEY (`id`),
KEY `telegrams_users_id_fk` (`user_id`),
CONSTRAINT `telegrams_users_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1


CREATE TABLE `publications` (
`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
`author` varchar(255) NOT NULL,
`name` varchar(255) NOT NULL,
`text` varchar(255) NOT NULL,
`created_at` datetime NOT NULL,
`updated_at` datetime NOT NULL,
`user_id` bigint(20) unsigned NOT NULL,
PRIMARY KEY (`id`),
KEY `publications_users_id_fk` (`user_id`),
CONSTRAINT `publications_users_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1


CREATE TABLE `tags` (
`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
`name` varchar(255) NOT NULL,
`created_at` datetime DEFAULT NULL,
`updated_at` datetime NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1


CREATE TABLE `tag_user` (
`user_id` bigint(20) unsigned NOT NULL,
`tag_id` bigint(20) unsigned NOT NULL,
KEY `tag_user_tags_id_fk` (`tag_id`),
KEY `tag_user_users_id_fk` (`user_id`),
CONSTRAINT `tag_user_tags_id_fk` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
CONSTRAINT `tag_user_users_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1

 */
