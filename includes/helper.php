<?php
declare(strict_types=1);

function e(string $teks): string
{
    return htmlspecialchars($teks, ENT_QUOTES, 'UTF-8');
}

function tandaWajib(): string
{
    return '<span class="wajib" aria-hidden="true">*</span>';
}

function pesanError(array $error, string $kolom): string
{
    if (!isset($error[$kolom])) {
        return '';
    }
    return '<p class="pesan-error" id="error-' . $kolom . '" role="alert">' . e($error[$kolom]) . '</p>';
}

function atributError(array $error, string $kolom): string
{
    return isset($error[$kolom]) ? ' aria-invalid="true" aria-describedby="error-' . $kolom . '"' : '';
}
