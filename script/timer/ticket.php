<?php
if (isset($_GET['uid'])) {
    $uid = $_GET['uid'];
    if (checkBID(checkUID($uid)['bid'])['paid_status'] == 1) {
        switch (checkUID($uid)['gender']) {
            case 'male':
                generatePDF(checkUID($uid)['nama'], $uid, checkBID(checkUID($uid)['bid'])['jenis'], checkBID(checkUID($uid)['bid'])['kategori'], 'Laki-Laki');
                break;
            case 'female':
                generatePDF(checkUID($uid)['nama'], $uid, checkBID(checkUID($uid)['bid'])['jenis'], checkBID(checkUID($uid)['bid'])['kategori'], 'Perempuan');
                break;
        }
    } else {
        header("Location:home");
    }
} else {
    header("Location:home");
}
function checkUID($uid)
{
    require '../db/db.php';
    try {
        $dbQuery = $dbConn->prepare("SELECT * FROM tuhm_users WHERE uid = ?");
        $dbQuery->bind_param("s", $uid);
        $dbQuery->execute();
        $result = $dbQuery->get_result();
        if ($result->num_rows === 0) {
            header("Location:home");
        }
        $dbGet = $result->fetch_array();
        return $dbGet;
    } catch (Exception $e) {
        return 'error fetching data';
    }
}
function checkBID($bid)
{
    require '../db/db.php';
    try {
        $dbQuery = $dbConn->prepare("SELECT * FROM tuhm_book WHERE bid = ?");
        $dbQuery->bind_param("s", $bid);
        $dbQuery->execute();
        $result = $dbQuery->get_result();
        if ($result->num_rows === 0) {
            header("Location:home");
        }
        $dbGet = $result->fetch_array();
        return $dbGet;
    } catch (Exception $e) {
        return 'error fetching data';
    }
}

function generatePDF($nama, $qrcode, $jenis, $kategori, $gender)
{
    require '../fpdf/fpdf.php';
    // $pdf = new FPDF();
    $pdf = new FPDF('P', 'mm', array(210, 250));
    $pdf->SetMargins(3, 3, 0, 0);
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetTitle("Ticket - " . $nama . " - TUHM 2019");
    $pdf->SetAuthor("Telkom University Fun Run 2019");
    $pdf->Image("ticket_footer.png", 0, 230, 210);
    $pdf->Image("ticket_header.png", 0, 0, 210);
    $qrAttach = "https://telkomuniversityrun.com/script/qrcode/php/qr_img.php?d=" . $qrcode;
    // $pdf->Image("assets/img/telfun.png", 10, 10, 40);
    $pdf->SetFont('Arial', 'B', 20);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(0, 45, "", 0, 1, 'C');
    $pdf->Cell(0, 7, $nama, 0, 1, 'C');

    $pdf->SetFont('Arial', '', 14);
    $pdf->SetTextColor(204, 0, 0);
    $pdf->Cell(0, 7, $jenis . ' - ' . $kategori, 0, 1, 'C');

    $pdf->SetFont('Arial', '', 14);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(0, 7, $gender, 0, 1, 'C');

    $pdf->Cell(0, 60, "", 0, 1, 'C');

    $pdf->Image($qrAttach, 72, 68, 68, 68, "png");

    $pdf->SetTextColor(102, 102, 102);
    $pdf->SetFont('Arial', '', 14);
    $pdf->Cell(0, 10, $qrcode, 0, 1, 'C');

    $pdf->Cell(0, 5, "", 0, 1, 'C');

    $pdf->SetFont('Arial', '', 14);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(0, 7, "Telkom Lembong", 0, 1, 'C');

    $pdf->SetFont('Arial', '', 12);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(0, 7, "Jl. Lembong No.36, Kota Bandung, Jawa Barat 40111", 0, 1, 'C');

    $pdf->SetFont('Arial', '', 12);
    $pdf->SetTextColor(102, 102, 102);
    $pdf->Cell(0, 7, "15 September 2019, 03.30 - selesai", 0, 1, 'C');

    $pdf->SetFont('Arial', '', 12);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(0, 5, "", 0, 1, 'C');

    $pdf->Cell(3, 10, "", 0, 1, 'C');
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 8, "Ketentuan Peserta Telkom University Half Marathon 2019 :", 0, 1, 'L');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(3, 5, "1. Dengan diterbitkannya Tiket ini, pemegang Tiket resmi menjadi Peserta Telkom University Half Marathon 2019.", 0, 1, 'L');
    $pdf->Cell(3, 5, "2. Peserta tidak diwajibkan mencetak Tiket ini.", 0, 1, 'L');
    $pdf->Cell(3, 5, "3. Tiket ini harus dibawa ketika ingin menukarkan dengan RacePack.", 0, 1, 'L');
    $pdf->Cell(3, 5, "4. RacePack dapat diambil di Telkom Lembong, alamat tertera pada tiket ini.", 0, 1, 'L');
    $pdf->Cell(3, 5, "5. Pengambilan RacePack dibuka pada tanggal 13 dan 14 September 2019.", 0, 1, 'L');
    $pdf->Cell(3, 5, "6. Peserta diwajibkan membaca Peraturan Acara, link tertera pada email pembayaran dan Website (telkomuniversityrun.com/rules).", 0, 1, 'L');
    $pdf->Cell(3, 5, "7. Website Resmi Telkom University Half Marathon adalah telkomuniversityrun.com, selain itu bukan merupakan bagian", 0, 1, 'L');
    $pdf->Cell(3, 5, "dari Telkom University Half Marathon.", 0, 1, 'L');

    $attach = $pdf->Output('I', "Ticket - " . $nama . " - TUHM 2019.pdf");
    return $attach;
}