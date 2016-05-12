SELECT
    L.id                                                AS '_id',
    L.address2                                          AS 'address.complement',
    L.address                                           AS 'address.street',
    L.zip_code                                          AS 'address.zipcode',
    L.avg_review                                        AS 'averageReview',
    IF(L.backlink = 'y', 1, 0)                          AS 'backlink',
    LB.badgeId                                          AS 'badgeId',
    LC.categoryId                                       AS 'categoryId',
    IF(L.claim_disable = 'y' OR L.account_id > 0, 0, 1) AS 'claim',
    D.friendly_url                                      AS 'dealFriendlyUrl',
    L.description                                       AS 'description',
    L.email                                             AS 'email',
    L.fax                                               AS 'fax',
    L.friendly_url                                      AS 'friendlyUrl',
    cast(IFNULL(L.latitude, 0) AS DECIMAL(10, 7))       AS 'geoLocation.lat',
    cast(IFNULL(L.longitude, 0) AS DECIMAL(10, 7))      AS 'geoLocation.lon',
    L.`level`                                           AS 'level',
    CONCAT_WS(' ',
              CASE WHEN L.location_1 THEN CONCAT('L1:', L.location_1) END,
              CASE WHEN L.location_2 THEN CONCAT('L2:', L.location_2) END,
              CASE WHEN L.location_3 THEN CONCAT('L3:', L.location_3) END,
              CASE WHEN L.location_4 THEN CONCAT('L4:', L.location_4) END,
              CASE WHEN L.location_5 THEN CONCAT('L5:', L.location_5) END
    )                                                   AS 'locationId',
    L.phone                                             AS 'phone',
    L.price                                             AS 'price',
    LRC.reviewCount                                     AS 'reviewCount',
    L.fulltextsearch_keyword                            AS 'searchInfo.keyword',
    L.fulltextsearch_where                              AS 'searchInfo.location',
    IF(L.status = 'A', 1, 0)                            AS 'status',
    L.fulltextsearch_keyword                            AS 'suggest.what.input',
    L.title                                             AS 'suggest.what.output',
    CONCAT(L.friendly_url, '|listing')                  AS 'suggest.what.payload',
    100 - L.level                                       AS 'suggest.what.weight',
    LI.thumbnail                                        AS 'thumbnail',
    L.title                                             AS 'title',
    L.url                                               AS 'url',
    L.number_views                                      AS 'views'
FROM `Listing` AS L
    LEFT JOIN (
                  SELECT
                      listing_id                                                     AS 'itemId',
                      GROUP_CONCAT(DISTINCT CONCAT('L:', category_id) SEPARATOR ' ') AS 'categoryId'
                  FROM Listing_Category
                  GROUP BY listing_id
              ) AS LC
        ON LC.itemId = L.id
    LEFT JOIN (
                  SELECT
                      listing_id                                   AS 'itemId',
                      GROUP_CONCAT(editor_choice_id SEPARATOR ' ') AS 'badgeId'
                  FROM Listing_Choice
                  GROUP BY listing_id
              ) AS LB
        ON LB.itemId = L.id
    LEFT JOIN (
                  SELECT
                      id,
                      CONCAT(`prefix`, 'photo_', id, '.', LOWER(`type`)) AS thumbnail
                  FROM Image
              ) AS LI
        ON LI.id = L.image_id
    LEFT JOIN (
                  SELECT
                      item_id  AS id,
                      COUNT(*) AS reviewCount
                  FROM Review
                  WHERE
                      item_type = 'listing' AND approved = 1
                  GROUP BY item_id
              ) AS LRC
        ON LRC.id = L.id
    LEFT JOIN Promotion AS D
        ON D.id = L.promotion_id
