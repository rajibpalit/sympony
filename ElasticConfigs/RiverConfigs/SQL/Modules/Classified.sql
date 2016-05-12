SELECT
    C.id                                           AS '_id',
    C.address2                                     AS 'address.complement',
    C.address                                      AS 'address.street',
    CONCAT_WS(' ',
              CASE WHEN C.cat_1_id THEN CONCAT('C:', C.cat_1_id) END,
              CASE WHEN C.cat_2_id THEN CONCAT('C:', C.cat_2_id) END,
              CASE WHEN C.cat_3_id THEN CONCAT('C:', C.cat_3_id) END,
              CASE WHEN C.cat_4_id THEN CONCAT('C:', C.cat_4_id) END,
              CASE WHEN C.cat_5_id THEN CONCAT('C:', C.cat_5_id) END
    )                                              AS 'categoryId',
    C.contactname                                  AS 'contactName',
    C.summarydesc                                  AS 'description',
    C.email                                        AS 'email',
    C.friendly_url                                 AS 'friendlyUrl',
    cast(IFNULL(C.latitude, 0) AS DECIMAL(10, 7))  AS 'geoLocation.lat',
    cast(IFNULL(C.longitude, 0) AS DECIMAL(10, 7)) AS 'geoLocation.lon',
    C.`level`                                      AS 'level',
    CONCAT_WS(' ',
              CASE WHEN C.location_1 THEN CONCAT('L1:', C.location_1) END,
              CASE WHEN C.location_2 THEN CONCAT('L2:', C.location_2) END,
              CASE WHEN C.location_3 THEN CONCAT('L3:', C.location_3) END,
              CASE WHEN C.location_4 THEN CONCAT('L4:', C.location_4) END,
              CASE WHEN C.location_5 THEN CONCAT('L5:', C.location_5) END
    )                                              AS 'locationId',
    C.phone                                        AS 'phone',
    C.classified_price                             AS 'price',
    C.fulltextsearch_keyword                       AS 'searchInfo.keyword',
    C.fulltextsearch_where                         AS 'searchInfo.location',
    if(C.status = 'A', 1, 0)                       AS 'status',
    C.fulltextsearch_keyword                       AS 'suggest.what.input',
    C.title                                        AS 'suggest.what.output',
    CONCAT(C.friendly_url, '|classified')          AS 'suggest.what.payload',
    100 - C.level                                  AS 'suggest.what.weight',
    CI.thumbnail                                   AS 'thumbnail',
    C.title                                        AS 'title',
    C.url                                          AS 'url',
    C.number_views                                 AS 'views'
FROM Classified AS C
    LEFT JOIN
    (
        SELECT
            id,
            CONCAT(`prefix`, 'photo_', id, '.', LOWER(`type`)) AS thumbnail
        FROM Image
    ) AS CI
        ON CI.id = C.image_id
