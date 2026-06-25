<?php
header('Content-type: application/json');
//@NimaDark045
//@APKReverseAcademy
class WhiteboxTables {
    private int $nr;
    private array $xor;
    private array $tyboxes;
    private array $tboxesLast;
    private array $mbl;

    public function __construct(int $nr, array $xor, array $tyboxes, array $tboxesLast, array $mbl) {
        $this->nr = $nr;
        $this->xor = $xor;
        $this->tyboxes = $tyboxes;
        $this->tboxesLast = $tboxesLast;
        $this->mbl = $mbl;
    }

    public function getNr(): int { return $this->nr; }
    public function getXor(): array { return $this->xor; }
    public function getTyboxes(): array { return $this->tyboxes; }
    public function getTboxesLast(): array { return $this->tboxesLast; }
    public function getMbl(): array { return $this->mbl; }
}
//============
class WBAESCTR {
    private WhiteboxTables $tables;

    public function __construct(WhiteboxTables $tables) {
        $this->tables = $tables;
    }

    private function urshift($a, $b) {
        if ($b <= 0) return $a;
        return ($a >> $b) & ~(1 << (32 - $b));
    }

    private function shiftRows(array &$bArr) {
        $iArr = [0, 5, 10, 15, 4, 9, 14, 3, 8, 13, 2, 7, 12, 1, 6, 11];
        $bArrCopyOf = $bArr;
        for ($i10 = 0; $i10 < 16; $i10++) {
            $bArr[$i10] = $bArrCopyOf[$iArr[$i10]];
        }
    }

    private function encryptBlock(array $bArr): array {
        $bArrCopyOf = $bArr;
        $iB = $this->tables->getNr() - 1;

        $tyboxes    = $this->tables->getTyboxes();
        $xorTable   = $this->tables->getXor();
        $mbl        = $this->tables->getMbl();
        $tboxesLast = $this->tables->getTboxesLast();

        for ($i10 = 0; $i10 < $iB; $i10++) {
            $this->shiftRows($bArrCopyOf);

            for ($i11 = 0; $i11 < 4; $i11++) {
                $i13 = $i11 * 4; $i14 = $i13 + 1; $i15 = $i13 + 2; $i16 = $i13 + 3;

                $iC  = $tyboxes[$i10][$i13][$bArrCopyOf[$i13] & 255]   & 0xFFFFFFFF;
                $iC2 = $tyboxes[$i10][$i14][$bArrCopyOf[$i14] & 255]   & 0xFFFFFFFF;
                $iC3 = $tyboxes[$i10][$i15][$bArrCopyOf[$i15] & 255]   & 0xFFFFFFFF;
                $iC4 = $tyboxes[$i10][$i16][$bArrCopyOf[$i16] & 255]   & 0xFFFFFFFF;

                for ($i17 = 0; $i17 < 4; $i17++) {
                    $i18 = ($i11 * 24) + ($i17 * 6);
                    $i19 = $i17 * 8; $i20 = 28 - $i19; $i22 = 24 - $i19;

                    $b10 = $xorTable[$i10][$i18][$this->urshift($iC, $i20) & 15][$this->urshift($iC2, $i20) & 15];
                    $b11 = $xorTable[$i10][$i18 + 1][$this->urshift($iC3, $i20) & 15][$this->urshift($iC4, $i20) & 15];

                    $idx2 = $xorTable[$i10][$i18 + 2][$this->urshift($iC, $i22) & 15][$this->urshift($iC2, $i22) & 15] & 255;
                    $idx3 = $xorTable[$i10][$i18 + 3][$this->urshift($iC3, $i22) & 15][$this->urshift($iC4, $i22) & 15] & 255;

                    $val5 = $xorTable[$i10][$i18 + 5][$idx2][$idx3];
                    $val4 = $xorTable[$i10][$i18 + 4][$b10 & 255][$b11 & 255];

                    $bArrCopyOf[$i13 + $i17] = ($val5 | ($val4 << 4)) & 255;
                }

                $iC5 = $mbl[$i10][$i13][$bArrCopyOf[$i13] & 255]   & 0xFFFFFFFF;
                $iC6 = $mbl[$i10][$i14][$bArrCopyOf[$i14] & 255]   & 0xFFFFFFFF;
                $iC7 = $mbl[$i10][$i15][$bArrCopyOf[$i15] & 255]   & 0xFFFFFFFF;
                $iC8 = $mbl[$i10][$i16][$bArrCopyOf[$i16] & 255]   & 0xFFFFFFFF;

                for ($i27 = 0; $i27 < 4; $i27++) {
                    $i28 = ($i11 * 24) + ($i27 * 6);
                    $i29 = $i27 * 8; $i30 = 28 - $i29; $i31 = 24 - $i29;

                    $idx_e0 = $xorTable[$i10][$i28][$this->urshift($iC5, $i30) & 15][$this->urshift($iC6, $i30) & 15] & 255;
                    $idx_e1 = $xorTable[$i10][$i28 + 1][$this->urshift($iC7, $i30) & 15][$this->urshift($iC8, $i30) & 15] & 255;
                    $idx_e2 = $xorTable[$i10][$i28 + 2][$this->urshift($iC5, $i31) & 15][$this->urshift($iC6, $i31) & 15] & 255;
                    $idx_e3 = $xorTable[$i10][$i28 + 3][$this->urshift($iC7, $i31) & 15][$this->urshift($iC8, $i31) & 15] & 255;

                    $val4_part = $xorTable[$i10][$i28 + 4][$idx_e0][$idx_e1] & 255;
                    $val5_part = $xorTable[$i10][$i28 + 5][$idx_e2][$idx_e3];

                    $bArrCopyOf[$i13 + $i27] = (($val4_part << 4) | $val5_part) & 255;
                }
            }
        }

        $this->shiftRows($bArrCopyOf);
        for ($i32 = 0; $i32 < 16; $i32++) {
            $bArrCopyOf[$i32] = $tboxesLast[$i32][$bArrCopyOf[$i32] & 255];
        }

        return $bArrCopyOf;
    }

    public function decrypt(string $ciphertextWithNonce): string {
        $bArr = array_values(unpack('C*', $ciphertextWithNonce));
        if (count($bArr) < 16) throw new InvalidArgumentException("Ciphertext truncated");

        $bArrQ   = array_slice($bArr, 0, 16); // Nonce
        $bArrQ2  = array_slice($bArr, 16);    // Ciphertext
        $bArr2   = array_fill(0, count($bArrQ2), 0);
        $bArrC   = array_fill(0, 16, 0);
        $bArrCopyOf = $bArrQ;

        $length = count($bArrQ2);
        for ($i11 = 0; $i11 < $length; $i11++) {
            $i12 = $i11 & 15;
            if ($i12 === 0) {
                $bArrC = $this->encryptBlock($bArrCopyOf);
                
                $i10 = 15;
                while (-1 < $i10) {
                    $b10 = ($bArrCopyOf[$i10] + 1) & 255;
                    $signed_b10 = $b10 > 127 ? $b10 - 256 : $b10;
                    $bArrCopyOf[$i10] = $b10;
                    $i10 = ($signed_b10 === 0) ? $i10 - 1 : -1;
                }
            }
            $bArr2[$i11] = $bArrC[$i12] ^ $bArrQ2[$i11];
        }
        return pack('C*', ...$bArr2);
    }
}
//============

class ConfigImporter {
    private WBAESCTR $wbaes;

    public function __construct(WBAESCTR $wbaes) {
        $this->wbaes = $wbaes;
    }
    private function decodeBase64(string $str): string {
        $cleanStr = preg_replace('/\s+/', '', $str);

        $decoded = base64_decode($cleanStr, true);
        if ($decoded === false) {
            $normalized = str_replace(['-', '_'], ['+', '/'], $cleanStr);
            $decoded = base64_decode($normalized);
        }
        return $decoded;
    }
    public function importConfig(string $importString) {
        try {
            $importString = trim($importString);
            if (strpos($importString, "NPVT1") !== 0) {
                throw new Exception("invalid config header");
            }
            $purePayload = trim(substr($importString, 5));
            $parts = preg_split('/\s*,\s*/', $purePayload);
            if (count($parts) !== 3) {
                throw new Exception("invalid config");
            }

            $decryptedParts = [];
            foreach ($parts as $part) {
                $binaryData = $this->decodeBase64(trim($part));
                $decryptedText = $this->wbaes->decrypt($binaryData);
                $decryptedParts[] = trim($decryptedText);
            }
            $configVersion = (int)$decryptedParts[0];
            if ($configVersion > 1) {
                throw new Exception("config requires up to date app");
            }
            $list2 = json_decode($decryptedParts[1], true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception("Failed to parse list2 JSON: " . json_last_error_msg());
            }
            $lVar = json_decode($decryptedParts[2], true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception("Failed to parse lVar JSON: " . json_last_error_msg());
            }
            return [
                'status'  => 'success',
                'version' => $configVersion,
                'servers' => $list2,
                'setting' => $lVar
            ];

        } catch (Exception $e) {
            return [
                'status'  => 'failed',
                'message' => $e->getMessage()
            ];
        }
    }
}




