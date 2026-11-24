
from pathlib import Path
import numpy as np
import pandas as pd

from PIL import Image
from skimage.metrics import (
    peak_signal_noise_ratio,
    structural_similarity
)

# Lokasi gambar
original_path = Path("asli/asli.png")
watermarked_dir = Path("watermarked")

# Membaca gambar asli
original = np.array(
    Image.open(original_path).convert("RGB")
)

results = []

# Membaca seluruh gambar hasil watermark
for image_path in sorted(watermarked_dir.glob("*.png")):

    watermarked = np.array(
        Image.open(image_path).convert("RGB")
    )

    # Pastikan dimensi sama
    if original.shape != watermarked.shape:
        print(f"Skip {image_path.name}: dimensi berbeda")
        continue

    # Menghitung PSNR
    psnr = peak_signal_noise_ratio(
        original,
        watermarked,
        data_range=255
    )

    # Menghitung SSIM
    ssim = structural_similarity(
        original,
        watermarked,
        channel_axis=2,
        data_range=255
    )

    # Menghitung MSE
    mse = np.mean(
        (original.astype(np.float64) -
         watermarked.astype(np.float64)) ** 2
    )

    results.append({
        "Payload": image_path.stem,
        "PSNR (dB)": round(psnr, 4),
        "SSIM": round(ssim, 6),
        "MSE": round(mse, 4)
    })

# Membuat tabel hasil
df = pd.DataFrame(results)

print("\nHASIL EVALUASI WATERMARKING")
print(df.to_string(index=False))

# Menyimpan hasil
df.to_csv("hasil_evaluasi.csv", index=False)

print("\nHasil disimpan ke hasil_evaluasi.csv")
