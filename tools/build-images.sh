#!/usr/bin/env bash
# =============================================================================
#  CORTILE — image pipeline
# =============================================================================
#  Takes the raw photographs in assets/img/src/ and produces the responsive
#  variants used by includes/functions.php (img()):
#
#     assets/img/<name>-480.jpg    thumbnails
#     assets/img/<name>-768.jpg    cards / mobile
#     assets/img/<name>-1024.jpg   tablets & retina cards
#     assets/img/<name>-1440.jpg   large sections
#     assets/img/<name>-1800.jpg   full-bleed hero
#
#  Each source is warmed slightly so that the whole site shares one light,
#  sunlit palette. No image is ever upscaled beyond its native resolution.
#
#  Requirements: ImageMagick 6+  (brew install imagemagick / apt install imagemagick)
#  Usage:        bash tools/build-images.sh
# =============================================================================

set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
SRC="$ROOT/assets/img/src"
OUT="$ROOT/assets/img"
WIDTHS=(480 768 1024 1440 1800)

if ! command -v convert >/dev/null 2>&1; then
  echo "ImageMagick (convert) is required." >&2
  exit 1
fi

# Per-image pre-crop (width x height + x + y). Keeps the subject centred and
# removes distracting edges from the original photographs.
declare -A CROP=(
  [dish-tiramisu]="920x1150+140+300"
  [dish-pannacotta]="1200x1500+0+330"
  [dish-branzino]="736x736+0+0"
  [hero]="1402x1122+0+0"
)

manifest="{"
first=1

for file in "$SRC"/*.jpg; do
  [ -e "$file" ] || continue
  name="$(basename "$file" .jpg)"
  work="$(mktemp -t cortile-XXXXXX).jpg"

  # 1. crop (if defined) 2. warm grade 3. gentle contrast
  if [[ -n "${CROP[$name]:-}" ]]; then
    convert "$file" -crop "${CROP[$name]}" +repage \
      -modulate 101,104,100 \
      -brightness-contrast 2x3 \
      -fill '#FAF3E6' -colorize 4% \
      "$work"
  else
    convert "$file" \
      -modulate 101,104,100 \
      -brightness-contrast 2x3 \
      -fill '#FAF3E6' -colorize 4% \
      "$work"
  fi

  # Small sources are gently upscaled so cards still look sharp on retina.
  native=$(identify -format "%w" "$work")
  if [ "$native" -lt 1000 ]; then
    convert "$work" -resize "1000x" -unsharp 0x0.8+0.7+0.02 "$work"
    native=$(identify -format "%w" "$work")
  fi

  available=()

  for w in "${WIDTHS[@]}"; do
    if [ "$w" -le "$native" ]; then
      convert "$work" -resize "${w}x" \
        -unsharp 0x0.7+0.6+0.02 \
        -strip -interlace Plane -sampling-factor 4:2:0 -quality 84 \
        "$OUT/${name}-${w}.jpg"
      available+=("$w")
    fi
  done

  # Small sources: keep a single, native-width variant.
  if [ ${#available[@]} -eq 0 ]; then
    convert "$work" -strip -interlace Plane -quality 84 "$OUT/${name}-${native}.jpg"
    available+=("$native")
  fi

  [ $first -eq 1 ] || manifest+=","
  first=0
  manifest+="\"$name\":[$(IFS=,; echo "${available[*]}")]"

  rm -f "$work"
  echo "  ✓ $name → ${available[*]} px"
done

manifest+="}"
printf '%s\n' "$manifest" > "$OUT/manifest.json"

echo ""
echo "Manifest written to assets/img/manifest.json"
