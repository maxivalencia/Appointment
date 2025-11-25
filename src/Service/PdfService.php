<?php
// src/Service/PdfService.php
namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfService
{
    private Dompdf $dompdf;

    public function __construct()
    {
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', true); // pour charger des images externes

        $this->dompdf = new Dompdf($options);
    }

    /**
     * Génère un PDF à partir d'un HTML
     *
     * @param string $html Contenu HTML
     * @param string $filename Nom du fichier PDF
     * @param bool $download Télécharger ou retourner le contenu
     */
    public function generatePdfFromHtml(string $html, string $filename = 'document.pdf', bool $download = true)
    {
        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A4', 'portrait');
        $this->dompdf->render();

        if ($download) {
            $this->dompdf->stream($filename, ['Attachment' => true]);
        } else {
            return $this->dompdf->output();
        }
    }
}
