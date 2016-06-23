using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Net;
using System.Web;
using UserCenter.Models.Common;

/// <summary>
/// Crawler 的摘要说明
/// </summary>
public class CrawlerHandler : Handler
{
    private string[] Sources;
    private Crawler[] Crawlers;
    public CrawlerHandler(HttpContext context) : base(context) { }

    public override void Process()
    {
        Sources = Request.Form.GetValues("source[]");
        if (Sources == null || Sources.Length == 0)
        {
            WriteJson(new
            {
                state = "参数错误：没有指定抓取源"
            });
            return;
        }
        Crawlers = Sources.Select(x => new Crawler(x, Server).Fetch()).ToArray();
        WriteJson(new
        {
            state = "SUCCESS",
            list = Crawlers.Select(x => new
            {
                state = x.State,
                source = x.SourceUrl,
                url = x.ServerUrl
            })
        });
    }
}

public class Crawler
{
    public string SourceUrl { get; set; }
    public string ServerUrl { get; set; }
    public string State { get; set; }

    private HttpServerUtility Server { get; set; }


    public Crawler(string sourceUrl, HttpServerUtility server)
    {
        this.SourceUrl = sourceUrl;
        this.Server = server;
    }

    public Crawler Fetch()
    {
        var request = HttpWebRequest.Create(this.SourceUrl) as HttpWebRequest;
        using (var response = request.GetResponse() as HttpWebResponse)
        {
            if (response.StatusCode != HttpStatusCode.OK)
            {
                State = "Url returns " + response.StatusCode + ", " + response.StatusDescription;
                return this;
            }
            if (response.ContentType.IndexOf("image") == -1)
            {
                State = "Url is not an image";
                return this;
            }
            //Delete By Arvin 20140811 粘贴图片改为接口上传
            //ServerUrl = PathFormatter.Format(Path.GetFileName(this.SourceUrl), Config.GetString("catcherPathFormat"));
            //var savePath = Server.MapPath(ServerUrl);
            //if (!Directory.Exists(Path.GetDirectoryName(savePath)))
            //{
            //    Directory.CreateDirectory(Path.GetDirectoryName(savePath));
            //}
            //Delete End
            try
            {
                var stream = response.GetResponseStream();
                var reader = new BinaryReader(stream);
                byte[] bytes;
                using (var ms = new MemoryStream())
                {
                    byte[] buffer = new byte[4096];
                    int count;
                    while ((count = reader.Read(buffer, 0, buffer.Length)) != 0)
                    {
                        ms.Write(buffer, 0, count);
                    }
                    bytes = ms.ToArray();
                }
                //Modify By Arvin 20140811 粘贴图片改为接口上传
                //File.WriteAllBytes(savePath, bytes);
                //获取用户所在公司ID
                UserCenter.Models.Model.SPUserCookie user = GlobalFuncs.GetUserInfoObj();
                if (user != null)
                {
                    ServerUrl = GlobalFuncs.CreatePicClientObj().SaveNewsImg(bytes, user.ComId);//新闻接口上传图片
                }
                //Modify End
                State = "SUCCESS";
            }
            catch (Exception e)
            {
                State = "抓取错误：" + e.Message;
            }
            return this;
        }
    }
}