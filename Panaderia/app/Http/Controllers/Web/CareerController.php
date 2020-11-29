<?php

namespace App\Http\Controllers\Web;

use App\Models\Accreditation;
use Illuminate\Http\Request;
use App\Models\Career;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Campus;
use App\Models\CampusCareer;
use App\Models\CampusImage;
use App\Models\CareerFile;
use App\Models\CareerRegime;
use App\Models\CareerScholarship;
use App\Models\CareerType;
use App\Models\Commune;
use App\Models\Country;
use App\Models\File;
use App\Models\Institution;
use App\Models\Modality;
use App\Models\Organization;
use App\Models\Province;
use App\Models\Region;
use App\Models\ScholarshipOwner;
use Facade\FlareClient\Http\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CareerController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        if ($user->hasRole('admin')) {
            return $this->adminIndex($request);
        } else {
            return $this->managerIndex();
        }
    }

    public function create(Request $request)
    {
        $user = auth()->user();
        $campuses = Institution::find($request->institution)->campuses->map(function ($campus) {
            return (object) [
                'id' => $campus->id,
                'name' => $campus->name,
            ];
        });
        $careerTypes = CareerType::all()->map(function ($careerType) {
            return (object) [
                'id' => $careerType->id,
                'name' => $careerType->name,
            ];
        });
        $areas = Area::all()->map(function ($area) {
            return (object) [
                'id' => $area->id,
                'name' => $area->name,
            ];
        });
        $modalities = Modality::all()->map(function ($modality) {
            return (object) [
                'id' => $modality->id,
                'name' => $modality->name,
            ];
        });

        $accreditations = Accreditation::all()->map(function ($accreditation) {
            return (object) [
                'id' => $accreditation->id,
                'name' => $accreditation->name,
            ];
        });

        $scholarshipOwners = ScholarshipOwner::all()->map(function ($scholarshipOwner) {
            $scholarships = $scholarshipOwner->scholarships;
            return (object) [
                'scholarships' => $scholarships,
                'name' => $scholarshipOwner->name,
                'id' => $scholarshipOwner->id,
            ];
        });
        return view('careers.create', [
            'institution_id' => $request->institution,
            'campuses' => $campuses,
            'types' => $careerTypes,
            'areas' => $areas,
            'modalities' => $modalities,
            'accreditations' => $accreditations,
            'admin' => $user->hasRole('admin'),
            'scholarShipOwners' => $scholarshipOwners,
            'regimes' => CareerRegime::all() ? CareerRegime::all() : null,
        ]);
    }

    public function show($id)
    {
        $career = Career::find($id);
        $institutionId = $career->institution_id;
        $user = auth()->user();
        $career_score = $career->career_score;

        $campuses = $career->institution->campuses->map(function ($campus) {
            return (object) [
                'id' => $campus->id,
                'name' => $campus->name,
            ];
        });

        $campuses = Institution::find($institutionId)->campuses;

        $careerTypes = CareerType::all()->map(function ($careerType) {
            return (object) [
                'id' => $careerType->id,
                'name' => $careerType->name,
            ];
        });
        $areas = Area::all()->map(function ($area) {
            return (object) [
                'id' => $area->id,
                'name' => $area->name,
            ];
        });
        $modalities = Modality::all()->map(function ($modality) {
            return (object) [
                'id' => $modality->id,
                'name' => $modality->name,
            ];
        });
        $accreditations = Accreditation::all()->map(function ($accreditation) {
            return (object) [
                'id' => $accreditation->id,
                'name' => $accreditation->name,
            ];
        });
        $career_campus = $career->campuses->map(function ($campus) {
            return (object) [
                'id' => $campus->id,
                'name' => $campus->name,
            ];
        });

        $regimes = CareerRegime::all()->map(function ($CareerRegime) {
            return (object) [
                'id' => $CareerRegime->id,
                'name' => $CareerRegime->name,
            ];
        });
        $brochure = $career->career_files
            ->filter(function ($career_file) use ($career) {
                return $career_file->id == $career->brochure_pdf;
            })
            ->first();
        $curricular_mesh = $career->career_files
            ->filter(function ($career_file) use ($career) {
                return $career_file->id == $career->curricular_mesh_pdf;
            })
            ->first();

        $career_image = $career->file;

        $career = (object) [
            'id' => $career->id,
            'name' => $career->name,
            'description' => $career->description,
            'link' => $career->link,
            'institution_name' => $career->institution->name,
            'institution_id' => $career->institution_id,
            'campuses' => $career_campus,
            'career_type' => $career->career_type,
            'accreditation' => $career->accreditation->name,
            'area' => $career->area,
            'modality' => $career->modality,
            'semesters' => $career->semesters,
            'video' => $career->video,
            'career_regime' => $career->career_regime,
            'brochure_pdf' => $brochure ? $brochure->file->id : null,
            'curricular_mesh_pdf' => $curricular_mesh ? $curricular_mesh->file->id : null,
            'editPermission'      => 'institutions.edit.' . $career->institution_id,
            'scholarships'        => $career->scholarships,
            'image'               => $career_image ? $career_image->id : 0 ,
        ];

        $scholarshipOwners = ScholarshipOwner::all()->map(function ($scholarshipOwner) {
            $scholarships = $scholarshipOwner->scholarships;
            return (object) [
                'scholarships' => $scholarships,
                'name' => $scholarshipOwner->name,
                'id' => $scholarshipOwner->id,
            ];
        });

        return view('careers.show', [
            'career' => $career,
            'campuses' => $campuses,
            'types' => $careerTypes,
            'accreditations' => $accreditations,
            'areas' => $areas,
            'modalities' => $modalities,
            'score' => $career_score,
            'scholarShipOwners' => $scholarshipOwners,
            'regimes' => $regimes,
        ]);
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        $this->createCareer($request->all());
        return redirect()->route('careers');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:3000'],
            'link' => ['required', 'string', 'url', 'max:255'],
            'video' => ['required', 'string', 'url', 'max:255'],
            'semesters' => ['required', 'int', 'max:255'],
            'type' => ['required', 'integer', 'exists:career_types,id'],
            'accreditation' => ['required', 'integer', 'exists:accreditations,id'],
            'area' => ['required', 'integer', 'exists:areas,id'],
            'modality' => ['required', 'integer', 'exists:modalities,id'],
            'campuses' => ['required'],
            'regime' => ['required', 'integer', 'exists:career_regimes,id'],
            'institution' => [
                'required',
                'integer',
                Rule::exists('institutions', 'id')->where(function ($query) {
                    if (
                        auth()
                            ->user()
                            ->hasRole('manager')
                    ) {
                        $query->where('organization_id', auth()->user()->organization_id);
                    }
                }),
            ],
        ]);
    }

    protected function createCareer(array $data)
    {
        $career = Career::create([
            'name' => $data['name'],
            'career_type_id' => $data['type'],
            'area_id' => $data['area'],
            'modality_id' => $data['modality'],
            'semesters' => $data['semesters'],
            'description' => $data['description'],
            'link' => $data['link'],
            'video' => $data['video'],
            'curricular_mesh_image' => null,
            'curricular_mesh_pdf' => null,
            'institution_id' => $data['institution'],
            'accreditation_id' => $data['accreditation'],
            'career_regime_id' => $data['regime'],
        ]);

        if (count($data['campuses']) > 0) {
            CampusCareer::where('career_id', $career->id)->delete();
            foreach ($data['campuses'] as $campusNew) {
                CampusCareer::create([
                    'campus_id' => $campusNew,
                    'career_id' => $career->id,
                ]);
            }
        }
        $scholarshipOwners = ScholarshipOwner::all()->map(function ($scholarshipOwner) {
            $scholarships = $scholarshipOwner->scholarships;
            return (object) [
                'scholarships' => $scholarships,
                'name' => $scholarshipOwner->name,
                'id' => $scholarshipOwner->id,
            ];
        });

        $scholarshipsOld = CareerScholarship::where('career_id', $career->id)->get();
        foreach ($scholarshipsOld as $scholarshipDel) {
            $scholarshipDel->delete();
        }

        foreach ($scholarshipOwners as $scholarshipOwner) {
            if (
                sizeof($data['scholarShipOwners' . $scholarshipOwner->id]) > 0 &&
                $data['scholarShipOwners' . $scholarshipOwner->id] != null
            ) {
                foreach ($data['scholarShipOwners' . $scholarshipOwner->id] as $scholarship) {
                    $careerScholarShip = CareerScholarship::create([
                        'scholarship_id' => $scholarship,
                        'career_id' => $career->id,
                    ]);
                }
            }
        }
    }

    public function update(Request $request)
    {
        $this->updateValidator($request->all())->validate();
        $this->updateCareer($request->all());
        return redirect()->route('careers.show', $request->id);
    }

    protected function updateValidator(array $data)
    {
        $user = auth()->user();
        return Validator::make($data, [
            'id' => ['required', 'integer', 'exists:careers,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:3000'],
            'link' => ['required', 'string', 'url', 'max:255'],
            'video' => ['required', 'string', 'url', 'max:255'],
            'semesters' => ['required', 'int', 'max:255'],
            'type' => ['required', 'integer', 'exists:career_types,id'],
            'accreditation' => ['required', 'integer', 'exists:accreditations,id'],
            'area' => ['required', 'integer', 'exists:areas,id'],
            'modality' => ['required', 'integer', 'exists:modalities,id'],
            'campuses' => ['required'],
            'regime' => ['required', 'integer', 'exists:career_regimes,id'],
            'institution' => [
                'required',
                'integer',
                Rule::exists('institutions', 'id')->where(function ($query) use ($user) {
                    if ($user->hasRole('manager')) {
                        $query->where('organization_id', auth()->user()->organization_id);
                    }
                }),
            ],
        ]);
    }

    protected function updateCareer(array $data)
    {
        $career = Career::find($data['id']);
        if ($career->name != $data['name']) {
            $career->name = $data['name'];
        }
        if ($career->description != $data['description']) {
            $career->description = $data['description'];
        }
        if ($career->link != $data['link']) {
            $career->link = $data['link'];
        }
        if ($career->video != $data['video']) {
            $career->video = $data['video'];
        }
        if ($career->semesters != $data['semesters']) {
            $career->semesters = $data['semesters'];
        }
        if ($career->career_type_id != $data['type']) {
            $career->career_type_id = $data['type'];
        }
        if ($career->accreditation_id != $data['accreditation']) {
            $career->accreditation_id = $data['accreditation'];
        }
        if ($career->area_id != $data['area']) {
            $career->area_id = $data['area'];
        }
        if ($career->modality_id != $data['modality']) {
            $career->modality_id = $data['modality'];
        }
        if ($career->career_regime_id != $data['regime']) {
            $career->career_regime_id = $data['regime'];
        }

        if (count($data['campuses']) > 0) {
            CampusCareer::where('career_id', $career->id)->delete();
            foreach ($data['campuses'] as $campusNew) {
                CampusCareer::create([
                    'campus_id' => $campusNew,
                    'career_id' => $career->id,
                ]);
            }
        }
        $scholarshipOwners = ScholarshipOwner::all()->map(function ($scholarshipOwner) {
            $scholarships = $scholarshipOwner->scholarships;
            return (object) [
                'scholarships' => $scholarships,
                'name' => $scholarshipOwner->name,
                'id' => $scholarshipOwner->id,
            ];
        });

        $scholarshipsOld = CareerScholarship::where('career_id', $career->id)->get();
        foreach ($scholarshipsOld as $scholarshipDel) {
            $scholarshipDel->delete();
        }

        foreach ($scholarshipOwners as $scholarshipOwner) {
            if (
                sizeof($data['scholarShipOwners' . $scholarshipOwner->id]) > 0 &&
                $data['scholarShipOwners' . $scholarshipOwner->id] != null
            ) {
                foreach ($data['scholarShipOwners' . $scholarshipOwner->id] as $scholarship) {
                    $careerScholarShip = CareerScholarship::create([
                        'scholarship_id' => $scholarship,
                        'career_id' => $career->id,
                    ]);
                }
            }
        }

        $career->save();
    }

    public function score_create(Request $request)
    {
        $data = $request->all();

        Validator::make($data, [
            'nem' => ['required', 'integer'],
            'ranking' => ['required', 'integer'],
            'math' => ['required', 'integer'],
            'history_science' => ['required', 'integer'],
            'language' => ['required', 'integer'],
            'max_score' => ['required', 'numeric'],
            'avg_score' => ['required', 'numeric'],
            'min_score' => ['required', 'numeric'],
            'id' => ['required', 'numeric'],
        ])->validate();

        $career = Career::find($data['id']);
        $career->career_score()->create([
            'nem' => $data['nem'],
            'ranking' => $data['ranking'],
            'math' => $data['math'],
            'language' => $data['language'],
            'history_science' => $data['history_science'],
            'max_score' => $data['max_score'],
            'avg_score' => $data['avg_score'],
            'min_score' => $data['min_score'],
        ]);

        return redirect()->route('careers.show', $data['id']);
    }

    public function score_delete(Request $request)
    {
        $data = $request->all();
        $career = Career::find($data['id']);
        $career->career_score->delete();

        return redirect()->route('careers.show', $data['id']);
    }

    public function brochure_create(Request $request)
    {
        $this->validatorAddFiles($request->all(), 'brochure')->validate();
        $career = Career::find($request->id);
        if ($career->brochure_pdf) {
            return redirect()->route('careers.show', $career->id);
        }

        $careerFile = CareerFile::create([
            'career_id' => $career->id,
        ]);
        File::create([
            'path' => $request->brochure->store('files'),
            'fileable_id' => $careerFile->id,
            'fileable_type' => 'App\Models\CareerFile',
        ]);

        $career->brochure_pdf = $careerFile->id;
        $career->save();

        return redirect()->route('careers.show', $career->id);
    }

    public function brochure_delete(Request $request)
    {
        $this->validatorDeleteFiles($request->all())->validate();
        $career = Career::find($request->id);
        if (!$career->brochure_pdf) {
            return redirect()->route('careers.show', $career->id);
        }

        $career_file = $career->career_files
            ->filter(function ($career_file) use ($career) {
                return $career->brochure_pdf == $career_file->id;
            })
            ->first();

        Storage::disk($career_file->file->disk)->delete($career_file->file->path);
        $career_file->file->delete();
        $career_file->delete();
        $career->brochure_pdf = null;
        $career->save();
        return redirect()->route('careers.show', $career->id);
    }

    public function curricularmesh_create(Request $request)
    {
        $this->validatorAddFiles($request->all(), 'curricular_mesh')->validate();
        $career = Career::find($request->id);

        if ($career->curricular_mesh_pdf) {
            return redirect()->route('careers.show', $career->id);
        }

        $careerFile = CareerFile::create([
            'career_id' => $career->id,
        ]);
        File::create([
            'path' => $request->curricular_mesh->store('files'),
            'fileable_id' => $careerFile->id,
            'fileable_type' => 'App\Models\CareerFile',
        ]);

        $career->curricular_mesh_pdf = $careerFile->id;
        $career->save();

        return redirect()->route('careers.show', $career->id);
    }
    public function curricularmesh_delete(Request $request)
    {
        $this->validatorDeleteFiles($request->all())->validate();
        $career = Career::find($request->id);
        if (!$career->curricular_mesh_pdf) {
            return redirect()->route('careers.show', $career->id);
        }

        $career_file = $career->career_files
            ->filter(function ($career_file) use ($career) {
                return $career->curricular_mesh_pdf == $career_file->id;
            })
            ->first();

        Storage::disk($career_file->file->disk)->delete($career_file->file->path);
        $career_file->file->delete();
        $career_file->delete();
        $career->curricular_mesh_pdf = null;
        $career->save();
        return redirect()->route('careers.show', $career->id);
    }

    protected function validatorAddFiles(array $data, $filename)
    {
        $max_upload_size = config('app.max_file_filesize');

        return Validator::make($data, [
            'id' => ['required', 'integer', 'exists:careers,id'],
            $filename => ['required', 'file', "max:$max_upload_size", 'mimes:jpeg,bmp,png,gif,svg,pdf'],
        ]);
    }

    protected function validatorDeleteFiles(array $data)
    {
        return Validator::make($data, [
            'id' => ['required', 'integer', 'exists:careers,id'],
            'image' => ['required', 'integer', 'exists:files,id'],
        ]);
    }

    protected function adminIndex(Request $request)
    {
        $organizations = Organization::all();
        $organization_id = $request->organization;
        $institutions = $organizations
            ->map(function ($organization) {
                return $organization->institutions->map(function ($institution) {
                    $careers = $institution->careers->map(function ($career) {
                        return (object) [
                            'id' => $career->id,
                            'name' => $career->name,
                            'description' => $career->description,
                            'area' => $career->area->name,
                            'modality' => $career->modality->name,
                            'semesters' => $career->semesters,
                            'link' => $career->link,
                        ];
                    });
                    return (object) [
                        'id' => $institution->id,
                        'name' => $institution->name,
                        'organization_id' => $institution->organization_id,
                        'campuses' => $institution->campuses->count(),
                        'careers' => $careers,
                    ];
                });
            })
            ->flatten();
        if ($organization_id) {
            $institutions = $institutions->filter(function ($institution) use ($organization_id) {
                return $institution->organization_id == $organization_id;
            });
        }
        $organizations = $organizations->map(function ($organization) {
            return (object) [
                'id' => $organization->id,
                'name' => $organization->fantasy_name,
            ];
        });
        return view('careers.index', [
            'institutions' => $institutions,
            'organizations' => $organizations,
            'organization_id' => $organization_id,
        ]);
    }

    protected function managerIndex()
    {
        $organization = auth()->user()->organization;
        $institutions = $organization->institutions->filter(function ($institution) {
            $institution_id = auth()
                ->user()
                ->institutionId();
            if ($institution_id) {
                return $institution->id == $institution_id;
            }
            return true;
        });
        $institutions = $institutions->map(function ($institution) {
            $careers = $institution->careers->map(function ($career) {
                return (object) [
                    'id' => $career->id,
                    'name' => $career->name,
                    'description' => $career->description,
                    'area' => $career->area->name,
                    'modality' => $career->modality->name,
                    'semesters' => $career->semesters,
                    'link' => $career->link,
                ];
            });
            return (object) [
                'id' => $institution->id,
                'name' => $institution->name,
                'campuses' => $institution->campuses->count(),
                'careers' => $careers,
            ];
        });

        return view('careers.index', [
            'institutions' => $institutions,
        ]);
    }

    public function image_create(Request $request)
    {
        $this->validatorImage($request->all(), 'image', true)->validate();
        $career = Career::find($request->career);

        if (!$career->file) {
            File::create([
                'path' => $request->image->store('files'),
                'fileable_id' => $request->career,
                'fileable_type' => 'App\Models\Career',
            ]);
        }

        return redirect()->route('careers.show', $request->career);
    }

    public function image_delete(Request $request)
    {
        $this->validatorImage($request->all(), 'image', false)->validate();
        $career = Career::find($request->career);
        if ($career->file) {
            Storage::disk($career->file->disk)->delete($career->file->path);
            $career->file->delete();
        }
        return redirect()->route('careers.show', $career->id);
    }

    protected function validatorImage(array $data, $image_name, $create)
    {
        $max_upload_size = config('app.max_image_filesize');

        if ($create) {
            return Validator::make($data, [
                $image_name => ['required', 'file', "max:$max_upload_size", 'image', 'mimes:jpeg,jpg,jpe,png,svg'],
            ]);
        } else {
            return Validator::make($data, [
                'image' => ['required', 'integer', 'exists:files,id'],
            ]);
        }
    }



}
