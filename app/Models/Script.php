<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Script
 * @package App\Models
 * @method static Builder|AnalyzedFile where($column, $operator = null, $value = null, $boolean = 'and')
 */
class Script extends Model
{
    use HasFactory;

    protected $table = 'scripts';
    protected $fillable = ['name', 'description', 'isActive', 'orderNumber', 'fileName'];
    /**
     * @var int|mixed
     */
    private $orderNumber;
    /**
     * @var mixed|string
     */
    private $fileName;
}
