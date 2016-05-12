SELECT
    CONCAT('L3:', L3.id)                                      AS '_id',
    L3.`name`                                                 AS 'title',
    L3.friendly_url                                           AS 'friendlyUrl',
    IF(L3.location_2 = 0, NULL, CONCAT('L2:', L3.location_2)) AS 'parentId',
    SL3.subLocation                                           AS 'subLocationId',
    3                                                         AS 'level',
    L3.name                                                   AS 'suggest.where.input',
    L3.friendly_url                                           AS 'suggest.where.payload'
FROM Location_3 AS L3
    LEFT JOIN
    (
        SELECT
            CONCAT('L4:', id) AS subLocation,
            location_3        AS parentId
        FROM Location_4
    ) AS SL3
        ON L3.id = SL3.parentId
