SELECT
    CONCAT('L4:', L4.id)                                      AS '_id',
    L4.`name`                                                 AS 'title',
    L4.friendly_url                                           AS 'friendlyUrl',
    IF(L4.location_3 = 0, NULL, CONCAT('L3:', L4.location_3)) AS 'parentId',
    SL4.subLocation                                           AS 'subLocationId',
    4                                                         AS 'level',
    L4.name                                                   AS 'suggest.where.input',
    L4.friendly_url                                           AS 'suggest.where.payload'
FROM Location_4 AS L4
    LEFT JOIN
    (
        SELECT
            CONCAT('L5:', id) AS subLocation,
            location_4        AS parentId
        FROM Location_5
    ) AS SL4
        ON L4.id = SL4.parentId
