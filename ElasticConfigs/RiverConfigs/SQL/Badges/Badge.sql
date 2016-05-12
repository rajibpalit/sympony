SELECT
    EC.id        AS '_id',
    EC.available AS 'available',
    BI.image     AS 'image',
    EC.name      AS 'name'
FROM Editor_Choice AS EC
    LEFT JOIN
    (
        SELECT
            id,
            CONCAT(`prefix`, 'photo_', id, '.', LOWER(`type`)) AS image
        FROM Image
    ) AS BI
        ON BI.id = EC.image_id