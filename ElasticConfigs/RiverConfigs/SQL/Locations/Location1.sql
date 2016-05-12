SELECT
    CONCAT('L1:', L1.id) AS '_id',
    L1.name              AS 'title',
    L1.friendly_url      AS 'friendlyUrl',
    NULL                 AS 'parentId',
    SL.subLocation       AS 'subLocationId',
    1                    AS 'level',
    L1.name              AS 'suggest.where.input',
    L1.friendly_url      AS 'suggest.where.payload'
FROM Location_1 AS L1
    LEFT JOIN
    (
        SELECT
            CONCAT('L2:', id) AS subLocation,
            location_1        AS parentId
        FROM Location_2
    ) AS SL ON L1.id = SL.parentId
