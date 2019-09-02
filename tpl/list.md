    
**简要描述：** 
- 查询数据列表

**请求列表URL：** 
- `{{domain}}/v1/DIR_NAME/CONTROLLER_NAME/listData`

**请求单条记录URL：**
- `{{domain}}/v1/DIR_NAME/CONTROLLER_NAME/info`
  
**请求方式：**
- POST 

**参数：** 

DATABASE_FILED1
| all_data | 否 | int | 传递参数为1时，不分页，返回所有数据 |
| page | 否 | int | 页码,默认1 |
| per_page | 否 | int | 每页返回条数，默认10条 |

**返回示例**

```json
{

}
```

**数据库字段说明**

DATABASE_FILED2

