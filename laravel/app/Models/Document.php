<?php

namespace App\Models;

use App\Http\Livewire\DocumentTypeModal;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use HasFactory;

    public const TEMP_DIR = 'temp/';
    protected $fillable = [
        'name',
        'path',
        'document_type_id',
        'entity_id',
        'build_id',
        'owner_id',
        'expirate_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
    ];

    public static function booted()
    {
        // When a document is created, a row in validation pivot table with "Pending" status is inserted
        Document::created(function ($document) {
            $document->validations()->attach(config('constants.DOCUMENT_VALIDATION_ID.Pendiente'), ['user_id' => auth()->user()->id]);
        });
    }

    /**
     * @return Attribute
     * Formated validated_at date
     */
    public function validatedAt(): Attribute
    {
        return Attribute::make(
            get: fn(string|null $date) => $date ? Carbon::create($date)->format('d-m-Y') : null
        );
    }

    public function validations()
    {
        return $this->belongsToMany(DocumentValidation::class, 'document_document_validations', 'document_id', 'validation_id')->withPivot(['observations', 'created_at'])->withTimestamps();
    }

    /**
     * @return Attribute
     * Formated validated_at date
     */
    public function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn(string|null $date) => $date ? Carbon::create($date)->format('d-m-Y H:i') : null
        );
    }

    public function document_type()
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function buildCompany()
    {
        return $this->belongsTo('build_company');
    }

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    /**
     * @param int $entity_id
     * @param int $owner_id
     * @return mixed the document owner's model instance
     */
    public function ownerEntity($entity_id, $owner_id)
    {
        switch ($entity_id) {
            case config('constants.ENTITY_TEMPLATE_ID.Worker'):
                return Worker::find($owner_id);
            case config('constants.ENTITY_TEMPLATE_ID.Machine'):
                return Machine::find($owner_id);
            case config('constants.ENTITY_TEMPLATE_ID.Company'):
                return Company::find($owner_id);
            default:
                return [];
        }
    }

    /**
     * @return mixed response with the file download
     */
    public function download()
    {
        $filePath = Storage::disk('ftp')->allFiles($this->path)[0];
        if ($filePath)
            return Storage::disk('ftp')->download($filePath);
    }

    /**
     * Download the file locally
     */
    public function downloadLocally()
    {

        // Store the document in local
        $filePath = Storage::disk('ftp')->allFiles($this->path)[0];
        if ($filePath)
            Storage::disk('public')->put(self::TEMP_DIR . $this->name, Storage::disk('ftp')->get($filePath));
    }

    /**
     * Delete the local copy of the file
     */
    public function deleteLocalFile()
    {
        $path = self::TEMP_DIR . $this->name;

        if (Storage::disk('public')->exists($path))
            Storage::disk('public')->delete($path);
    }

    /**
     * Get expirated documents
     */
    public function expiratedDocuments()
    {
        return Document::where('expirate_at', '>', now());
    }

    public function getLatestValidation()
    {
        return $this->validations()->orderByPivot('created_at', 'desc');
    }
}
