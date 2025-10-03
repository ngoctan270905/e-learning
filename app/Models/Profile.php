<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use HasFactory;

    /**
     * Thuộc tính có thể được gán giá trị hàng loạt (Mass Assignable).
     * Đảm bảo bạn có thể tạo/cập nhật Profile dễ dàng.
     * * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'bio',
        'birthday',
        'avatar_url',
    ];

    /**
     * Định nghĩa quan hệ One-to-One với User.
     * Một Profile thuộc về (belongs to) một User.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        // Quan hệ: Profile belongs to User
        return $this->belongsTo(User::class);
    }
}