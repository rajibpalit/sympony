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
