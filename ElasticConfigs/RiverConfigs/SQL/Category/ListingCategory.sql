SELECT
    CONCAT('L:', C.id)                                       AS '_id',
    C.title                                                  AS 'title',
    C.content                                                AS 'content',
    C.friendly_url                                           AS 'friendlyUrl',
    IF(C.category_id = 0, NULL, CONCAT('L:', C.category_id)) AS 'parentId',
    SCL.id                                                   AS 'subCategoryId',
    'listing'                                                AS 'module',
    C.title                                                  AS 'suggest.what.input',
    CONCAT(C.friendly_url, '|listingCategory')               AS 'suggest.what.payload',
    100                                                      AS 'suggest.what.weight',
    C.summary_description                                    AS 'description',
    C.seo_description                                        AS 'seo.description',
    C.seo_keywords                                           AS 'seo.keywords',
    C.page_title                                             AS 'seo.title'
FROM
    ListingCategory AS C
    LEFT JOIN (
                  SELECT
                      CONCAT('L:', id) AS id,
                      category_id      AS 'parentId'
                  FROM ListingCategory
              ) AS SCL
        ON SCL.parentId = C.id
