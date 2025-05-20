<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'name', // Nombre del rol (ejemplo: "superadmin", "funcionario-compra", etc.)
    ];

    /**
     * Obtiene los usuarios que tienen este rol.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }

    /**
     * Asigna un rol a un usuario.
     *
     * @param int $userId
     */
    public function assignToUser($userId)
    {
        $this->users()->attach($userId);
    }

    /**
     * Remueve un rol de un usuario.
     *
     * @param int $userId
     */
    public function removeFromUser($userId)
    {
        $this->users()->detach($userId);
    }

    /**
     * Verifica si un rol tiene un nombre específico.
     *
     * @param string $roleName
     * @return bool
     */
    public function isNamed($roleName)
    {
        return $this->name === $roleName;
    }

    /**
     * Busca un rol por su nombre.
     *
     * @param string $roleName
     * @return Role|null
     */
    public static function findByName($roleName)
    {
        return self::where('name', $roleName)->first();
    }
}