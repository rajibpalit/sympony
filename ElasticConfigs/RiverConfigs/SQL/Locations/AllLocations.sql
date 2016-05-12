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
    ) AS SL
        ON L1.id = SL.parentId
UNION
(
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
)
UNION
(
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
)
UNION
(
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
)
UNION
(
    SELECT
        CONCAT('L5:', L5.id)                                      AS '_id',
        L5.`name`                                                 AS 'title',
        L5.friendly_url                                           AS 'friendlyUrl',
        IF(L5.location_4 = 0, NULL, CONCAT('L4:', L5.location_4)) AS 'parentId',
        NULL                                                      AS 'subLocationId',
        5                                                         AS 'level',
        L5.name                                                   AS 'suggest.where.input',
        L5.friendly_url                                           AS 'suggest.where.payload'
    FROM Location_5 AS L5
)
