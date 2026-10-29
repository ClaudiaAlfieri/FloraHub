<?php

namespace Database\Seeders;

use App\Enums\Difficulty;
use App\Enums\Light;
use App\Enums\Watering;
use App\Models\Family;
use App\Models\Species;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SpeciesSeeder extends Seeder
{
    /**
     * Seed the species of the catalogue. It needs the families of the FamilySeeder.
     */
    public function run(): void
    {
        $species = [
            [
                'family' => 'araceae',
                'scientific_name' => 'Monstera deliciosa',
                'common_name' => 'Costela-de-adão',
                'description' => 'Trepadeira tropical de folhas grandes e recortadas, muito popular como planta de interior.',
                'light' => Light::BrightIndirect,
                'watering' => Watering::Weekly,
                'difficulty' => Difficulty::Easy,
                'toxic_to_pets' => true,
                'care_notes' => 'Deixar secar os primeiros 3–5 cm de solo entre regas. Luz indireta e brilhante, sem sol direto ao meio-dia.',
            ],
            [
                'family' => 'araceae',
                'scientific_name' => 'Epipremnum aureum',
                'common_name' => 'Jibóia',
                'description' => 'Trepadeira de crescimento rápido, com folhas em forma de coração, verdes e amarelas.',
                'light' => Light::Medium,
                'watering' => Watering::Weekly,
                'difficulty' => Difficulty::Easy,
                'toxic_to_pets' => true,
                'care_notes' => 'Tolera pouca luz, mas cresce melhor com luz indireta. Regar quando o solo estiver seco à superfície.',
            ],
            [
                'family' => 'araceae',
                'scientific_name' => 'Zamioculcas zamiifolia',
                'common_name' => 'Zamioculca',
                'description' => 'Planta muito resistente, com folhas brilhantes e rizomas que armazenam água.',
                'light' => Light::Low,
                'watering' => Watering::Biweekly,
                'difficulty' => Difficulty::Easy,
                'toxic_to_pets' => true,
                'care_notes' => 'Evitar o excesso de rega: os rizomas apodrecem com o solo encharcado.',
            ],
            [
                'family' => 'asparagaceae',
                'scientific_name' => 'Dracaena trifasciata',
                'common_name' => 'Espada-de-são-jorge',
                'description' => 'Folhas eretas, rígidas e listradas. Conhecida antes como Sansevieria trifasciata.',
                'light' => Light::Low,
                'watering' => Watering::Monthly,
                'difficulty' => Difficulty::Easy,
                'toxic_to_pets' => true,
                'care_notes' => 'Regar pouco, sobretudo no inverno. Substrato com boa drenagem.',
            ],
            [
                'family' => 'asparagaceae',
                'scientific_name' => 'Chlorophytum comosum',
                'common_name' => 'Clorofito',
                'description' => 'Folhas compridas e arqueadas, verdes e brancas, que produzem pequenas plantas-filhas.',
                'light' => Light::BrightIndirect,
                'watering' => Watering::Weekly,
                'difficulty' => Difficulty::Easy,
                'toxic_to_pets' => false,
                'care_notes' => 'As plantas-filhas podem ser cortadas e enraizadas em água.',
            ],
            [
                'family' => 'cactaceae',
                'scientific_name' => 'Schlumbergera truncata',
                'common_name' => 'Cato-de-natal',
                'description' => 'Cato epífito sem espinhos, que floresce no inverno.',
                'light' => Light::BrightIndirect,
                'watering' => Watering::Weekly,
                'difficulty' => Difficulty::Medium,
                'toxic_to_pets' => false,
                'care_notes' => 'Precisa de noites longas e frescas no outono para florir.',
            ],
            [
                'family' => 'crassulaceae',
                'scientific_name' => 'Crassula ovata',
                'common_name' => 'Árvore-de-jade',
                'description' => 'Suculenta arbustiva de folhas carnudas e tronco grosso.',
                'light' => Light::Direct,
                'watering' => Watering::Biweekly,
                'difficulty' => Difficulty::Easy,
                'toxic_to_pets' => true,
                'care_notes' => 'Deixar o solo secar completamente entre regas.',
            ],
            [
                'family' => 'lamiaceae',
                'scientific_name' => 'Lavandula angustifolia',
                'common_name' => 'Alfazema',
                'description' => 'Arbusto aromático de flores violeta, usado em perfumaria e na cozinha.',
                'light' => Light::Direct,
                'watering' => Watering::Weekly,
                'difficulty' => Difficulty::Medium,
                'toxic_to_pets' => false,
                'care_notes' => 'Precisa de sol pleno e de solo bem drenado. Podar depois da floração.',
            ],
            [
                'family' => 'lamiaceae',
                'scientific_name' => 'Ocimum basilicum',
                'common_name' => 'Manjericão',
                'description' => 'Erva aromática anual, muito usada na cozinha mediterrânica.',
                'light' => Light::Direct,
                'watering' => Watering::Frequent,
                'difficulty' => Difficulty::Easy,
                'toxic_to_pets' => false,
                'care_notes' => 'Manter o solo húmido e cortar as flores para prolongar a produção de folhas.',
            ],
            [
                'family' => 'marantaceae',
                'scientific_name' => 'Calathea orbifolia',
                'common_name' => 'Calateia',
                'description' => 'Folhas grandes e redondas, com riscas prateadas.',
                'light' => Light::Medium,
                'watering' => Watering::Weekly,
                'difficulty' => Difficulty::Hard,
                'toxic_to_pets' => false,
                'care_notes' => 'Gosta de humidade elevada e de água sem calcário. Evitar sol direto.',
            ],
            [
                'family' => 'moraceae',
                'scientific_name' => 'Ficus lyrata',
                'common_name' => 'Figueira-lira',
                'description' => 'Árvore de folhas grandes em forma de lira, muito usada em decoração.',
                'light' => Light::BrightIndirect,
                'watering' => Watering::Weekly,
                'difficulty' => Difficulty::Hard,
                'toxic_to_pets' => true,
                'care_notes' => 'Não gosta de mudanças de lugar nem de correntes de ar.',
            ],
            [
                'family' => 'orchidaceae',
                'scientific_name' => 'Phalaenopsis amabilis',
                'common_name' => 'Orquídea-borboleta',
                'description' => 'Orquídea epífita de flores brancas e duradouras.',
                'light' => Light::BrightIndirect,
                'watering' => Watering::Weekly,
                'difficulty' => Difficulty::Medium,
                'toxic_to_pets' => false,
                'care_notes' => 'Regar por imersão e deixar escorrer. Usar substrato de casca de pinheiro.',
            ],
        ];

        foreach ($species as $data) {
            $family = Family::withTrashed()->where('slug', $data['family'])->firstOrFail();

            unset($data['family']);

            Species::withTrashed()->updateOrCreate(
                ['scientific_name' => $data['scientific_name']],
                [...$data, 'family_id' => $family->id, 'slug' => Str::slug($data['scientific_name'])],
            );
        }
    }
}
