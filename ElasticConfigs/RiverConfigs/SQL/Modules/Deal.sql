SELECT
    D.id                                                                         AS '_id',
    L.address2                                                                   AS 'address.complement',
    L.address                                                                    AS 'address.street',
    D.amount                                                                     AS 'amount',
    LC.categoryId                                                                AS 'categoryId',
    IF(D.end_date = '0000-00-00', NULL, DATE_FORMAT(D.end_date, '%Y-%m-%d'))     AS 'date.end',
    IF(D.start_date = '0000-00-00', NULL, DATE_FORMAT(D.start_date, '%Y-%m-%d')) AS 'date.start',
    D.description                                                                AS 'description',
    D.friendly_url                                                               AS 'friendlyUrl',
    cast(IFNULL(L.latitude, 0) AS DECIMAL(10, 7))                                AS 'geoLocation.lat',
    cast(IFNULL(L.longitude, 0) AS DECIMAL(10, 7))                               AS 'geoLocation.lon',
    L.level                                                                      AS 'level',
    L.friendly_url                                                               AS 'listing.friendlyUrl',
    L.title                                                                      AS 'listing.title',
    CONCAT_WS(' ',
              CASE WHEN L.location_1 THEN CONCAT('L1:', L.location_1) END,
              CASE WHEN L.location_2 THEN CONCAT('L2:', L.location_2) END,
              CASE WHEN L.location_3 THEN CONCAT('L3:', L.location_3) END,
              CASE WHEN L.location_4 THEN CONCAT('L4:', L.location_4) END,
              CASE WHEN L.location_5 THEN CONCAT('L5:', L.location_5) END
    )                                                                            AS 'locationId',
    D.fulltextsearch_keyword                                                     AS 'searchInfo.keyword',
    D.fulltextsearch_where                                                       AS 'searchInfo.where',
    IF(L.status = 'A', TRUE, FALSE)                                              AS 'status',
    D.fulltextsearch_keyword                                                     AS 'suggest.what.input',
    D.name                                                                       AS 'suggest.what.output',
    CONCAT(D.friendly_url, '|deal')                                              AS 'suggest.what.payload',
    100 - L.level                                                                AS 'suggest.what.weight',
    DI.thumbnail                                                                 AS 'thumbnail',
    D.name                                                                       AS 'title',
    D.dealvalue                                                                  AS 'value.deal',
    D.realvalue                                                                  AS 'value.real',
    D.number_views                                                               AS 'views'
FROM Promotion AS D
    LEFT JOIN (
                  SELECT
                      id,
                      CONCAT(`prefix`, 'photo_', id, '.', LOWER(`type`)) AS thumbnail
                  FROM Image
              ) AS DI
        ON DI.id = D.image_id
    LEFT JOIN (
                  SELECT
                      listing_id                                                     AS 'itemId',
                      GROUP_CONCAT(DISTINCT CONCAT('L:', category_id) SEPARATOR ' ') AS 'categoryId'
                  FROM Listing_Category
                  GROUP BY listing_id
              ) AS LC
        ON LC.itemId = D.listing_id
    LEFT JOIN Listing AS L
        ON D.listing_id = L.id
