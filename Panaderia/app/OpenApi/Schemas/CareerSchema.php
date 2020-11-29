<?php

namespace App\OpenApi\Schemas;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AllOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AnyOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Not;
use GoldSpecDigital\ObjectOrientedOAS\Objects\OneOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class CareerSchema extends SchemaFactory implements Reusable
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('Career')->properties(
            Schema::integer('id')
                ->format(Schema::FORMAT_INT64)
                ->description('ID of the Career'),
            Schema::string('name')->description('Name of the Career'),
            Schema::string('description')->description('Description of the Career'),
            Schema::string('link')->description('Link of the Career'),
            Schema::integer('semesters')->description('Semesters of the Career'),
            Schema::string('area')->description('Area of the Career'),
            Schema::string('type')->description('Type of the Career'),
            Schema::string('modality')->description('Modality of the Career'),
            Schema::integer('brochure_pdf')->format(Schema::FORMAT_INT64)->description('ID of a Brochure Pdf File of the Career'),
            Schema::integer('curricular_mesh_pdf')->format(Schema::FORMAT_INT64)->description('ID of a Curricular Mesh Pdf file of the Career'),
            Schema::array('scores')->items(
                Schema::object()->properties(
                    Schema::integer('id')
                        ->format(Schema::FORMAT_INT64)
                        ->description('ID of the Career Score Relation'),
                    Schema::integer('career_id')
                        ->format(Schema::FORMAT_INT64)
                        ->description('ID of the Career'),
                    Schema::integer('year')->description('Year of the current Career Score '),
                    Schema::integer('nem')->description('Nem of the current Career Score '),
                    Schema::integer('ranking')->description('Renking of the current Career Score '),
                    Schema::integer('math')->description('Math score of the current Career Score '),
                    Schema::integer('history_science')->description('History and Science score of the current Career Score '),
                    Schema::integer('max_score')->description('Current year max score'),
                    Schema::integer('avg_score')->description('Current year average score'),
                    Schema::integer('min_score')->description('Current year minimun score'),
                )
            ),
            Schema::array('accreditation')->items(
                Schema::object()->properties(
                    Schema::integer('id')
                        ->format(Schema::FORMAT_INT64)
                        ->description('ID of the Acreditation'),
                    Schema::string('name')->description('Name of the Acreditation'),
                )
            ),
            Schema::array('scholarship_owners')->items(
                Schema::integer('id')
                    ->format(Schema::FORMAT_INT64)
                    ->description('ID of the ScholarshipOwner'),
                Schema::string('name')->description('Name of the ScholarshipOwner'),
                Schema::integer('scholarship_count')->description('Count of the Scholarships in these ScholarshipOwner'),
            ),

            Schema::array('scholarships')->items(
                Schema::integer('id')
                    ->format(Schema::FORMAT_INT64)
                    ->description('ID of the Scholarship'),
                Schema::string('name')->description('Name of the Scholarship'),
                Schema::integer('scholarship_owner_id')
                    ->format(Schema::FORMAT_INT64)
                    ->description('ID of the ScholarshipOwner'),
            ),
            
            
        );
    }
}
