SELECT
    E.id                                                                         AS '_id',
    E.location                                                                   AS 'address.location',
    E.address                                                                    AS 'address.street',
    E.zip_code                                                                   AS 'address.zipcode',
    CONCAT_WS(' ',
              CASE WHEN E.cat_1_id THEN CONCAT('E:', E.cat_1_id) END,
              CASE WHEN E.cat_2_id THEN CONCAT('E:', E.cat_2_id) END,
              CASE WHEN E.cat_3_id THEN CONCAT('E:', E.cat_3_id) END,
              CASE WHEN E.cat_4_id THEN CONCAT('E:', E.cat_4_id) END,
              CASE WHEN E.cat_5_id THEN CONCAT('E:', E.cat_5_id) END
    )                                                                            AS 'categoryId',
    IF(E.end_date = '0000-00-00', NULL, DATE_FORMAT(E.end_date, '%Y-%m-%d'))     AS 'date.end',
    IF(E.start_date = '0000-00-00', NULL, DATE_FORMAT(E.start_date, '%Y-%m-%d')) AS 'date.start',
    IF(E.has_end_time = 'n', NULL, TIME_FORMAT(E.end_time, '%T'))                AS 'time.end',
    IF(E.has_start_time = 'n', NULL, TIME_FORMAT(E.start_time, '%T'))            AS 'time.start',
    E.description                                                                AS 'description',
    E.email                                                                      AS 'email',
    E.friendly_url                                                               AS 'friendlyUrl',
    cast(IFNULL(E.latitude, 0) AS DECIMAL(10, 7))                                AS 'geoLocation.lat',
    cast(IFNULL(E.longitude, 0) AS DECIMAL(10, 7))                               AS 'geoLocation.lon',
    E.`level`                                                                    AS 'level',
    CONCAT_WS(' ',
              CASE WHEN E.location_1 THEN CONCAT('L1:', E.location_1) END,
              CASE WHEN E.location_2 THEN CONCAT('L2:', E.location_2) END,
              CASE WHEN E.location_3 THEN CONCAT('L3:', E.location_3) END,
              CASE WHEN E.location_4 THEN CONCAT('L4:', E.location_4) END,
              CASE WHEN E.location_5 THEN CONCAT('L5:', E.location_5) END
    )                                                                            AS 'locationId',
    E.phone                                                                      AS 'phone',
    IF(E.recurring = 'Y', TRUE, FALSE)                                           AS 'recurring.enabled',
    IF(E.until_date = '0000-00-00', NULL, DATE_FORMAT(E.until_date, '%Y-%m-%d')) AS 'recurring.until',
    E.fulltextsearch_keyword                                                     AS 'searchInfo.keyword',
    E.fulltextsearch_where                                                       AS 'searchInfo.location',
    IF(E.status = 'A', TRUE, FALSE)                                              AS 'status',
    E.fulltextsearch_keyword                                                     AS 'suggest.what.input',
    E.title                                                                      AS 'suggest.what.output',
    CONCAT(E.friendly_url, '|event')                                             AS 'suggest.what.payload',
    100 - E.level                                                                AS 'suggest.what.weight',
    ET.thumbnail                                                                 AS 'thumbnail',
    E.title                                                                      AS 'title',
    E.url                                                                        AS 'url',
    E.number_views                                                               AS 'views'
FROM
    Event AS E
    LEFT JOIN
    (
        SELECT
            id,
            CONCAT(`prefix`, 'photo_', id, '.', LOWER(`type`)) AS thumbnail
        FROM Image
    ) AS ET
        ON ET.id = E.image_id
