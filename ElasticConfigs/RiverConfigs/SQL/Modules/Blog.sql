SELECT
    B.id                                        AS '_id',
    BC.categoryId                               AS 'categoryId',
    BCC.commentCount                            AS 'commentCount',
    B.content                                   AS 'content',
    B.friendly_url                              AS 'friendlyUrl',
    10                                          AS 'level',
    DATE_FORMAT(B.entered, '%Y-%m-%d %H:%i:%s') AS 'publicationDate',
    B.fulltextsearch_keyword                    AS 'searchInfo.keyword',
    if(B.status = 'A', 1, 0)                    AS 'status',
    B.fulltextsearch_keyword                    AS 'suggest.what.input',
    B.title                                     AS 'suggest.what.output',
    CONCAT(B.friendly_url, '|blog')             AS 'suggest.what.payload',
    90                                          AS 'suggest.what.weight',
    BI.thumbnail                                AS 'thumbnail',
    B.title                                     AS 'title',
    B.number_views                              AS 'views'
FROM Post AS B
    LEFT JOIN
    (
        SELECT
            id,
            CONCAT(`prefix`, 'photo_', id, '.', LOWER(`type`)) AS thumbnail
        FROM Image
    ) AS BI
        ON BI.id = B.image_id
    LEFT JOIN (
                  SELECT
                      post_id                                                        AS 'itemId',
                      GROUP_CONCAT(DISTINCT CONCAT('B:', category_id) SEPARATOR ' ') AS 'categoryId'
                  FROM Blog_Category
                  GROUP BY itemId
              ) AS BC
        ON BC.itemId = B.id
    LEFT JOIN
    (
        SELECT
            post_id  AS id,
            COUNT(*) AS commentCount
        FROM Comments
        GROUP BY post_id
    ) AS BCC
        ON BCC.id = B.id
