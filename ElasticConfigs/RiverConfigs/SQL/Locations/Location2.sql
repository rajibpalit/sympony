SELECT
    CONCAT('L2:', L2.id)                                      AS '_id',
    L2.`name`                                                 AS 'title',
    L2.friendly_url                                           AS 'friendlyUrl',
    IF(L2.location_1 = 0, NULL, CONCAT('L1:', L2.location_1)) AS 'parentId',
    SL2.subLocation                                           AS 'subLocationId',
    2                                                         AS 'level',
    L2.name                                                   AS 'suggest.where.input',
    L2.friendly_url                                           AS 'suggest.where.payload'
FROM Location_2 AS L2
    LEFT JOIN
    (
        SELECT
            CONCAT('L3:', id) AS subLocation,
            location_2        AS parentId
        FROM Location_3
    ) AS SL2
        ON L2.id = SL2.parentId
