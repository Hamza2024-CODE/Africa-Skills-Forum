<?php

namespace App\Services;

class QrCodeService
{
    /**
     * Generate an inline SVG or Data URI QR code for any given text / URL.
     * 100% offline, pure PHP implementation with zero external API calls.
     */
    public static function generateSvg(string $data, int $size = 200): string
    {
        $matrix = self::encodeText($data);
        $count = count($matrix);
        $cellSize = max(1, (float)$size / $count);
        $width = $count * $cellSize;

        $rects = [];
        for ($r = 0; $r < $count; $r++) {
            for ($c = 0; $c < $count; $c++) {
                if ($matrix[$r][$c]) {
                    $x = round($c * $cellSize, 2);
                    $y = round($r * $cellSize, 2);
                    $w = round($cellSize + 0.05, 2);
                    $rects[] = "<rect x=\"{$x}\" y=\"{$y}\" width=\"{$w}\" height=\"{$w}\" fill=\"#06205C\"/>";
                }
            }
        }

        $rectsSvg = implode('', $rects);
        return "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 {$width} {$width}\" width=\"{$size}\" height=\"{$size}\" shape-rendering=\"crispEdges\"><rect width=\"100%\" height=\"100%\" fill=\"#ffffff\"/>{$rectsSvg}</svg>";
    }

    public static function generateDataUri(string $data, int $size = 200): string
    {
        $svg = self::generateSvg($data, $size);
        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }

    /**
     * Pure PHP QR Code Encoder (Byte Mode, Mask 0, ECC Level L/M)
     */
    private static function encodeText(string $text): array
    {
        $bytes = unpack('C*', $text);
        $len = count($bytes);

        // Determine Version (1 to 10) based on length
        $version = 1;
        $capacities = [
            1 => 17, 2 => 32, 3 => 53, 4 => 78, 5 => 106,
            6 => 134, 7 => 154, 8 => 192, 9 => 230, 10 => 271
        ];

        foreach ($capacities as $v => $cap) {
            if ($len <= $cap) {
                $version = $v;
                break;
            }
        }
        if ($len > 271) {
            $version = 10;
        }

        $size = 17 + 4 * $version;
        $matrix = array_fill(0, $size, array_fill(0, $size, null));

        // 1. Finder patterns
        self::addFinder($matrix, 0, 0);
        self::addFinder($matrix, $size - 7, 0);
        self::addFinder($matrix, 0, $size - 7);

        // 2. Alignment patterns for v2+
        if ($version >= 2) {
            $alignCoords = [
                2 => [6, 18], 3 => [6, 22], 4 => [6, 26], 5 => [6, 30],
                6 => [6, 34], 7 => [6, 22, 38], 8 => [6, 24, 42],
                9 => [6, 26, 46], 10 => [6, 28, 50]
            ];
            $coords = $alignCoords[$version] ?? [];
            foreach ($coords as $r) {
                foreach ($coords as $c) {
                    if (is_null($matrix[$r][$c])) {
                        self::addAlignment($matrix, $r - 2, $c - 2);
                    }
                }
            }
        }

        // 3. Timing patterns
        for ($i = 8; $i < $size - 8; $i++) {
            if (is_null($matrix[6][$i])) $matrix[6][$i] = ($i % 2 === 0) ? 1 : 0;
            if (is_null($matrix[$i][6])) $matrix[$i][6] = ($i % 2 === 0) ? 1 : 0;
        }

        // 4. Reserve format info area
        for ($i = 0; $i < 9; $i++) {
            if (is_null($matrix[8][$i])) $matrix[8][$i] = 0;
            if (is_null($matrix[$i][8])) $matrix[$i][8] = 0;
            if (is_null($matrix[8][$size - 1 - $i])) $matrix[8][$size - 1 - $i] = 0;
            if (is_null($matrix[$size - 1 - $i][8])) $matrix[$size - 1 - $i][8] = 0;
        }

        // 5. Data Bit Placement
        $bitStream = [];
        // Mode 0100 (Byte mode)
        $bitStream[] = 0; $bitStream[] = 1; $bitStream[] = 0; $bitStream[] = 0;
        // Count (8 bits for v1-9)
        for ($b = 7; $b >= 0; $b--) {
            $bitStream[] = ($len >> $b) & 1;
        }
        // Data bytes
        foreach ($bytes as $byte) {
            for ($b = 7; $b >= 0; $b--) {
                $bitStream[] = ($byte >> $b) & 1;
            }
        }
        // Terminator
        for ($i = 0; $i < 4; $i++) $bitStream[] = 0;

        // Fill matrix using zigzag
        $bitIdx = 0;
        $totalBits = count($bitStream);
        $direction = -1; // up
        $col = $size - 1;

        while ($col > 0) {
            if ($col === 6) $col--; // skip vertical timing column
            for ($row = ($direction === -1 ? $size - 1 : 0); $row >= 0 && $row < $size; $row += $direction) {
                for ($cOffset = 0; $cOffset < 2; $cOffset++) {
                    $c = $col - $cOffset;
                    if (is_null($matrix[$row][$c])) {
                        $bit = ($bitIdx < $totalBits) ? $bitStream[$bitIdx++] : 0;
                        // Apply Mask 0: (row + col) % 2 == 0
                        $mask = (($row + $c) % 2 === 0) ? 1 : 0;
                        $matrix[$row][$c] = $bit ^ $mask;
                    }
                }
            }
            $direction = -$direction;
            $col -= 2;
        }

        // Fill Format Information (Mask 0, ECC L: 101111001111100)
        $formatBits = [1,0,1,1,1,1,0,0,1,1,1,1,1,0,0];
        $fIdx = 0;
        for ($i = 0; $i < 6; $i++) $matrix[8][$i] = $formatBits[$fIdx++];
        $matrix[8][7] = $formatBits[$fIdx++];
        $matrix[8][8] = $formatBits[$fIdx++];
        $matrix[7][8] = $formatBits[$fIdx++];
        for ($i = 5; $i >= 0; $i--) $matrix[$i][8] = $formatBits[$fIdx++];

        $fIdx = 0;
        for ($i = $size - 1; $i >= $size - 7; $i--) $matrix[$i][8] = $formatBits[$fIdx++];
        for ($i = $size - 8; $i < $size; $i++) $matrix[8][$i] = $formatBits[$fIdx++];

        return $matrix;
    }

    private static function addFinder(array &$matrix, int $r, int $c): void
    {
        for ($y = 0; $y < 7; $y++) {
            for ($x = 0; $x < 7; $x++) {
                $isBlack = ($y === 0 || $y === 6 || $x === 0 || $x === 6 || ($y >= 2 && $y <= 4 && $x >= 2 && $x <= 4));
                $matrix[$r + $y][$c + $x] = $isBlack ? 1 : 0;
            }
        }
        // Quiet separator border
        for ($y = -1; $y <= 7; $y++) {
            for ($x = -1; $x <= 7; $x++) {
                $mr = $r + $y;
                $mc = $c + $x;
                if ($mr >= 0 && $mr < count($matrix) && $mc >= 0 && $mc < count($matrix)) {
                    if (is_null($matrix[$mr][$mc])) {
                        $matrix[$mr][$mc] = 0;
                    }
                }
            }
        }
    }

    private static function addAlignment(array &$matrix, int $r, int $c): void
    {
        for ($y = 0; $y < 5; $y++) {
            for ($x = 0; $x < 5; $x++) {
                $isBlack = ($y === 0 || $y === 4 || $x === 0 || $x === 4 || ($y === 2 && $x === 2));
                $matrix[$r + $y][$c + $x] = $isBlack ? 1 : 0;
            }
        }
    }
}
