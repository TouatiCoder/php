-- Add `stock` and `images` columns to products
ALTER TABLE products
  ADD COLUMN stock INT NOT NULL DEFAULT 0,
  ADD COLUMN images TEXT DEFAULT NULL;

-- If you prefer JSON type and MySQL supports it, use:
-- ALTER TABLE products ADD COLUMN images JSON DEFAULT NULL;

-- After running, you can populate `images` with JSON arrays, e.g.:
-- UPDATE products SET images = JSON_ARRAY(img) WHERE images IS NULL AND img IS NOT NULL;
