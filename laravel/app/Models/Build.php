<?php

namespace App\Models;

use App\Traits\HasDocuments;
use App\Traits\UseContactInfo;
use App\Traits\UseDirectoryStructure;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Build extends Model
{
    use HasFactory, UseContactInfo, UseDirectoryStructure, HasDocuments;
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'description',
        'category_id',
        'promoter_id',
        'contact_info_id',
    ];

    public function category()
    {
        return $this->belongsTo(BuildCategory::class);
    }

    public function promoter()
    {
        return $this->belongsTo(Promoter::class);
    }

    public function externals()
    {
        return $this->belongsToMany(User::class, 'build_external');
    }

    public function construction_managers()
    {
        return $this->belongsToMany(User::class, 'build_construction_manager');
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'build_company')->withTimestamps();
    }

    public function machines()
    {
        return $this->belongsToMany(Machine::class, 'build_machine')->withTimestamps();
    }

    public function templates()
    {
        return $this->belongsTo(DocumentTemplate::class, 'document_template_id');
    }

    public function startDate(): Attribute
    {
        return Attribute::make(
            get: fn (string $date) => Carbon::create($date)->format('d-m-Y')
        );
    }

    public function endDate(): Attribute
    {
        return Attribute::make(
            get: fn (string|null $date) => $date ? Carbon::create($date)->format('d-m-Y') : null
        );
    }

    /**
     * @return int days between start and end date
     */
    public function period(): int
    {
        return Carbon::create($this->start_date)->diffInDays(Carbon::create($this->end_date ? $this->end_date : Carbon::now()));
    }

    public function workers()
    {
        return $this->belongsToMany(Worker::class)->withTimestamps();
    }

    public function workersByCompany($company_id)
    {
        return $this->workers()->get()->where('company_id', $company_id);
    }

    /**
     * Get the documents path for a given $build
     * @return string
     */
    private function getDocumentPath($company)
    {
        return  date('Y') . '/' . $this->name . '/' . $company->name . Self::DOCUMENT_PATH;
    }
}
