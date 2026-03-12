<?php

namespace Database\Seeders;

use App\Models\Canton;
use App\Models\Provincia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CantonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provincias = [
            "AZUAY",
            "BOLIVAR",
            "CAÑAR",
            "CARCHI",
            "CHIMBORAZO",
            "COTOPAXI",
            "EL ORO",
            "ESMERALDAS",
            "GALAPAGOS",
            "GUAYAS",
            "IMBABURA",
            "LOJA",
            "LOS RIOS",
            "MANABI",
            "MORONA SANTIAGO",
            "NAPO",
            "ORELLANA",
            "PASTAZA",
            "PICHINCHA",
            "SANTA ELENA",
            "SANTO DOMINGO DE LOS TSACHILAS",
            "SUCUMBIOS",
            "TUNGURAHUA",
            "ZAMORA CHINCHIPE"
        ];
        $cantones = [
            [
                "CAMILO PONCE ENRÍQUEZ",
                "CHORDELEG",
                "CUENCA",
                "EL PAN",
                "GIRÓN",
                "GUACHAPALA",
                "GUALACEO",
                "NABÓN",
                "OÑA",
                "PAUTE",
                "PUCARÁ",
                "SAN FERNANDO",
                "SANTA ISABEL",
                "SEVILLA DE ORO",
                "SÍGSIG"
            ],
            [
                "CALUMA",
                "CHILLANES",
                "CHIMBO",
                "ECHEANDÍA",
                "GUARANDA",
                "LAS NAVES",
                "SAN MIGUEL"
            ],
            [
                "AZOGUES",
                "BIBLIÁN",
                "CAÑAR",
                "DÉLEG",
                "EL TAMBO",
                "LA TRONCAL",
                "SUSCAL"
            ],
            [
                "BOLÍVAR",
                "EL ÁNGEL",
                "HUACA",
                "MIRA",
                "SAN GABRIEL",
                "TULCÁN"
            ],
            [
                "ALAUSÍ",
                "CHAMBO",
                "CHUNCHI",
                "CUMANDÁ",
                "GUAMOTE",
                "GUANO",
                "PALLATANGA",
                "PENIPE",
                "RIOBAMBA",
                "VILLA LA UNIÓN (CAJABAMBA)"
            ],
            [
                "EL CORAZÓN",
                "LA MANÁ",
                "LATACUNGA",
                "PUJILÍ",
                "SAN MIGUEL DE SALCEDO",
                "SAQUISILÍ",
                "SIGCHOS"
            ],
            [
                "ARENILLAS",
                "BALSAS",
                "CHILLA",
                "EL GUABO",
                "HUAQUILLAS",
                "LA VICTORIA",
                "MACHALA",
                "MARCABELÍ",
                "PACCHA",
                "PASAJE",
                "PIÑAS",
                "PORTOVELO",
                "SANTA ROSA",
                "ZARUMA"
            ],
            [
                "ATACAMES",
                "ESMERALDAS",
                "MUISNE",
                "RIOVERDE",
                "ROSA ZÁRATE",
                "SAN LORENZO",
                "VALDEZ (LIMONES)"
            ],
            [
                "PUERTO AYORA",
                "PUERTO BAQUERIZO MORENO",
                "PUERTO VILLAMIL"
            ],
            [
                "ALFREDO BAQUERIZO MORENO",
                "BALAO",
                "BALZAR",
                "CNEL. MARCELINO MARIDUEÑA",
                "COLIMES",
                "DAULE",
                "DURÁN",
                "EL TRIUNFO",
                "GENERAL VILLAMIL",
                "GRAL. ANTONIO ELIZALDE (BUCAY)",
                "GUAYAQUIL",
                "ISIDRO AYORA",
                "LOMAS DE SARGENTILLO",
                "MILAGRO",
                "NARANJAL",
                "NARANJITO",
                "NOBOL",
                "PALESTINA",
                "PEDRO CARBO",
                "SALITRE",
                "SAMBORONDÓN",
                "SANTA LUCÍA",
                "SIMÓN BOLÍVAR",
                "VELASCO IBARRA",
                "YAGUACHI"
            ],
            [
                "ATUNTAQUI",
                "COTACACHI",
                "IBARRA",
                "OTAVALO",
                "PIMAMPIRO",
                "URCUQUÍ"
            ],
            [
                "ALAMOR",
                "AMALUZA",
                "CARIAMANGA",
                "CATACOCHA",
                "CATAMAYO",
                "CELICA",
                "CHAGUARPAMBA",
                "GONZANAMÁ",
                "LOJA",
                "MACARÁ",
                "OLMEDO",
                "PINDAL",
                "QUILANGA",
                "SARAGURO",
                "SOZORANGA",
                "ZAPOTILLO"
            ],
            [
                "BABA",
                "BABAHOYO",
                "BUENA FE",
                "CATARAMA",
                "MOCACHE",
                "MONTALVO",
                "PALENQUE",
                "PUEBLOVIEJO",
                "QUEVEDO",
                "QUINSALOMA",
                "VALENCIA",
                "VENTANAS",
                "VINCES"
            ],
            [
                "BAHÍA DE CARÁQUEZ",
                "CALCETA",
                "CHONE",
                "EL CARMEN",
                "FLAVIO ALFARO",
                "JAMA",
                "JARAMIJÓ",
                "JIPIJAPA",
                "JUNÍN",
                "MANTA",
                "MONTECRISTI",
                "OLMEDO",
                "PAJÁN",
                "PEDERNALES",
                "PICHINCHA",
                "PORTOVIEJO",
                "PUERTO LÓPEZ",
                "ROCAFUERTE",
                "SAN VICENTE",
                "SANTA ANA",
                "SUCRE",
                "TOSAGUA"
            ],
            [
                "GRAL. LEONIDAS PLAZA GUTIÉRREZ (LIMÓN)",
                "GUALAQUIZA",
                "HUAMBOYA",
                "LOGROÑO",
                "MACAS",
                "PABLO SEXTO",
                "PALORA",
                "SAN JUAN BOSCO",
                "SANTIAGO",
                "SANTIAGO DE MÉNDEZ",
                "SUCÚA",
                "TAISHA"
            ],
            [
                "ARCHIDONA",
                "BAEZA",
                "CARLOS JULIO AROSEMENA TOLA",
                "EL CHACO",
                "TENA"
            ],
            [
                "LA JOYA DE LOS SACHAS",
                "LORETO",
                "PUERTO FRANCISCO DE ORELLANA",
                "TIPUTINI"
            ],
            [
                "ARAJUNO",
                "MERA",
                "PUYO",
                "SANTA CLARA"
            ],
            [
                "CAYAMBE",
                "MACHACHI",
                "PEDRO VICENTE MALDONADO",
                "PUERTO QUITO",
                "QUITO",
                "SAN MIGUEL DE LOS BANCOS",
                "SANGOLQUÍ",
                "TABACUNDO"
            ],
            [
                "LA LIBERTAD",
                "SALINAS",
                "SANTA ELENA"
            ],
            [
                "LA CONCORDIA",
                "SANTO DOMINGO"
            ],
            [
                "EL DORADO DE CASCALES",
                "LA BONITA",
                "LUMBAQUI",
                "NUEVA LOJA",
                "PUERTO EL CARMEN DE PUTUMAYO",
                "SHUSHUFINDI",
                "TARAPOA"
            ],
            [
                "AMBATO",
                "BAÑOS DE AGUA SANTA",
                "CEVALLOS",
                "MOCHA",
                "PATATE",
                "PELILEO",
                "PÍLLARO",
                "QUERO",
                "TISALEO"
            ],
            [
                "EL PANGUI",
                "GUAYZIMI",
                "PALANDA",
                "PAQUISHA",
                "YACUAMBI",
                "YANTZAZA",
                "ZAMORA",
                "ZUMBA",
                "ZUMBI"
            ]
        ];
        $i = 0;
        foreach ($provincias as $provincia) {
            $provinciaM = Provincia::create([
                'nombre' => $provincia
            ]);
            foreach ($cantones[$i] as $canton) {
                Canton::create([
                    'nombre' => $canton,
                    'provincia_id' => $provinciaM->id,
                ]);
            }
            $i++;
        }
    }
}
